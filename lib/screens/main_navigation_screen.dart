import 'package:flutter/material.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';
import '../core/constants/app_constants.dart';
import '../core/services/tax_lien_service.dart';
import '../core/services/ai_investment_advisor_service.dart';
import '../core/services/magento_api_service.dart';
import '../core/services/secure_storage_service.dart';
import '../core/services/theme_service.dart';
import '../core/services/localization_service.dart';
import '../core/services/analytics_service.dart';
import '../core/services/notification_service.dart';
import '../core/models/magento_models.dart';
import '../core/providers/app_providers.dart';
import '../core/widgets/loading_screen.dart';
import 'home_screen.dart';
import 'marketplace_screen.dart';
import 'portfolio_dashboard_screen.dart';
import 'ai_advisor_screen.dart';
import 'profile_screen.dart';

class MainNavigationScreen extends ConsumerStatefulWidget {
  const MainNavigationScreen({super.key});

  @override
  ConsumerState<MainNavigationScreen> createState() => _MainNavigationScreenState();
}

class _MainNavigationScreenState extends ConsumerState<MainNavigationScreen> {
  int _selectedIndex = 0;
  late TaxLienService _taxLienService;
  late AIInvestmentAdvisorService _aiService;
  late MagentoApiService _magentoService;
  late SecureStorageService _secureStorage;
  late ThemeService _themeService;
  late LocalizationService _localizationService;
  late AnalyticsService _analyticsService;
  late NotificationService _notificationService;

  @override
  void initState() {
    super.initState();
    _initializeServices();
  }

  void _initializeServices() {
    _taxLienService = TaxLienService();
    _aiService = AIInvestmentAdvisorService();
    _magentoService = MagentoApiService();
    _secureStorage = SecureStorageService();
    _themeService = ThemeService();
    _localizationService = LocalizationService();
    _analyticsService = AnalyticsService();
    _notificationService = NotificationService();
    
    // Initialize services
    _taxLienService.initialize();
  }

  void _onItemTapped(int index) {
    setState(() {
      _selectedIndex = index;
    });
  }

  @override
  Widget build(BuildContext context) {
    final themeMode = ref.watch(themeProvider);
    final locale = ref.watch(localizationProvider);
    final authState = ref.watch(authProvider);
    final magentoState = ref.watch(magentoProvider);

    return Scaffold(
      body: IndexedStack(
        index: _selectedIndex,
        children: [
          HomeScreen(
            taxLienService: _taxLienService,
            aiService: _aiService,
            magentoService: _magentoService,
          ),
          MarketplaceScreen(
            taxLienService: _taxLienService,
            magentoService: _magentoService,
          ),
          PortfolioDashboardScreen(
            taxLienService: _taxLienService,
            aiService: _aiService,
          ),
          AIAdvisorScreen(
            taxLienService: _taxLienService,
            aiService: _aiService,
          ),
          ProfileScreen(
            authService: _secureStorage,
            themeService: _themeService,
            localizationService: _localizationService,
          ),
        ],
      ),
      bottomNavigationBar: BottomNavigationBar(
        type: BottomNavigationBarType.fixed,
        currentIndex: _selectedIndex,
        onTap: _onItemTapped,
        selectedItemColor: Theme.of(context).colorScheme.primary,
        unselectedItemColor: Theme.of(context).colorScheme.onSurfaceVariant,
        selectedLabelStyle: const TextStyle(fontWeight: FontWeight.w600),
        unselectedLabelStyle: const TextStyle(fontWeight: FontWeight.normal),
        items: const [
          BottomNavigationBarItem(
            icon: Icon(Icons.home),
            label: 'Главная',
          ),
          BottomNavigationBarItem(
            icon: Icon(Icons.store),
            label: 'Маркетплейс',
          ),
          BottomNavigationBarItem(
            icon: Icon(Icons.pie_chart),
            label: 'Портфель',
          ),
          BottomNavigationBarItem(
            icon: Icon(Icons.psychology),
            label: 'AI Советник',
          ),
          BottomNavigationBarItem(
            icon: Icon(Icons.person),
            label: 'Профиль',
          ),
        ],
      ),
    );
  }
}
