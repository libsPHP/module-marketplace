import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:flutter/foundation.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';
import 'package:flutter_localizations/flutter_localizations.dart';
import 'package:flutter_gen/gen_l10n/app_localizations.dart';

// Core imports
import 'core/constants/app_constants.dart';
import 'core/theme/app_theme.dart';
import 'core/services/magento_api_service.dart';
import 'core/services/theme_service.dart';
import 'core/services/localization_service.dart';
import 'core/services/analytics_service.dart';
import 'core/services/notification_service.dart';
import 'core/services/secure_storage_service.dart';
import 'core/models/magento_models.dart';
import 'core/providers/app_providers.dart';

// Widgets
import 'core/widgets/loading_screen.dart';

// Screens
import 'screens/main_navigation_screen.dart';

void main() async {
  WidgetsFlutterBinding.ensureInitialized();

  // Set preferred orientations
  await SystemChrome.setPreferredOrientations([
    DeviceOrientation.portraitUp,
    DeviceOrientation.portraitDown,
  ]);

  // Set system UI overlay style
  SystemChrome.setSystemUIOverlayStyle(
    const SystemUiOverlayStyle(
      statusBarColor: Colors.transparent,
      statusBarIconBrightness: Brightness.dark,
      systemNavigationBarColor: Colors.transparent,
      systemNavigationBarIconBrightness: Brightness.dark,
    ),
  );

  // Initialize services
  await _initializeServices();

  runApp(
    const ProviderScope(
      child: NativeMarketplaceApp(),
    ),
  );
}

Future<void> _initializeServices() async {
  // Initialize secure storage
  await SecureStorageService.initialize();
  
  // Initialize analytics
  if (AppConstants.enableAnalytics) {
    await AnalyticsService.initialize();
  }
  
  // Initialize notifications
  if (AppConstants.enablePushNotifications) {
    await NotificationService.initialize();
  }
}

/// Main application widget
class NativeMarketplaceApp extends ConsumerWidget {
  const NativeMarketplaceApp({super.key});

  @override
  Widget build(BuildContext context, WidgetRef ref) {
    final themeMode = ref.watch(themeProvider);
    final locale = ref.watch(localizationProvider);

    return MaterialApp(
      title: AppConstants.appName,
      debugShowCheckedModeBanner: false,
      
      // Theme configuration
      theme: AppTheme.lightTheme,
      darkTheme: AppTheme.darkTheme,
      themeMode: themeMode,
      
      // Localization configuration
      locale: locale,
      supportedLocales: AppLocalizations.supportedLocales,
      localizationsDelegates: const [
        AppLocalizations.delegate,
        GlobalMaterialLocalizations.delegate,
        GlobalWidgetsLocalizations.delegate,
        GlobalCupertinoLocalizations.delegate,
      ],
      
      // Home page
      home: const MainNavigationScreen(),
      
      // Error handling
      builder: (context, child) {
        return ErrorBoundary(
          child: child ?? const LoadingScreen(),
        );
      },
    );
  }
}

/// Error boundary widget to catch and handle errors gracefully
class ErrorBoundary extends StatefulWidget {
  final Widget child;

  const ErrorBoundary({
    super.key,
    required this.child,
  });

  @override
  State<ErrorBoundary> createState() => _ErrorBoundaryState();
}

class _ErrorBoundaryState extends State<ErrorBoundary> {
  Error? _error;

  @override
  void initState() {
    super.initState();
    _setupErrorHandling();
  }

  void _setupErrorHandling() {
    // Flutter error handling
    FlutterError.onError = (FlutterErrorDetails details) {
      if (AppConstants.enableCrashlytics) {
        // Report to crashlytics
        // CrashlyticsService.recordFlutterError(details);
      }
      
      // Show error dialog in debug mode
      if (kDebugMode) {
        _showErrorDialog(details.exception.toString());
      }
    };

    // Platform error handling
    PlatformDispatcher.instance.onError = (error, stack) {
      if (AppConstants.enableCrashlytics) {
        // Report to crashlytics
        // CrashlyticsService.recordError(error, stack);
      }
      
      // Show error dialog in debug mode
      if (kDebugMode) {
        _showErrorDialog(error.toString());
      }
      
      return true;
    };
  }

  void _showErrorDialog(String error) {
    if (mounted) {
      showDialog(
        context: context,
        builder: (context) => AlertDialog(
          title: const Text('Error'),
          content: Text(error),
          actions: [
            TextButton(
              onPressed: () => Navigator.of(context).pop(),
              child: const Text('OK'),
            ),
          ],
        ),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    if (_error != null) {
      return _buildErrorScreen();
    }

    return widget.child;
  }

  Widget _buildErrorScreen() {
    return Scaffold(
      body: Center(
        child: Padding(
          padding: const EdgeInsets.all(24.0),
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Icon(
                Icons.error_outline,
                size: 64,
                color: Theme.of(context).colorScheme.error,
              ),
              const SizedBox(height: 16),
              Text(
                'Something went wrong',
                style: Theme.of(context).textTheme.headlineSmall,
                textAlign: TextAlign.center,
              ),
              const SizedBox(height: 8),
              Text(
                'An unexpected error occurred. Please try again.',
                style: Theme.of(context).textTheme.bodyMedium,
                textAlign: TextAlign.center,
              ),
              const SizedBox(height: 24),
              ElevatedButton(
                onPressed: () {
                  setState(() {
                    _error = null;
                  });
                },
                child: const Text('Try Again'),
              ),
            ],
          ),
        ),
      ),
    );
  }
}
