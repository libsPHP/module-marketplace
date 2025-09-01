class AppConstants {
  // App Information
  static const String appName = 'TaxLien.online';
  static const String appDescription = 'Native marketplace for tax lien investments';
  static const String appVersion = '1.0.0';
  
  // API Configuration
  static const String baseUrl = 'https://taxlien.online/api';
  static const String magentoApiUrl = 'https://taxlien.online/graphql';
  static const String restApiUrl = 'https://taxlien.online/rest/V1';
  
  // Pagination
  static const int defaultPageSize = 20;
  static const int maxPageSize = 100;
  
  // Cache
  static const int cacheExpirationHours = 24;
  static const String cacheKeyPrefix = 'native_marketplace_';
  
  // Storage Keys
  static const String keyAuthToken = 'auth_token';
  static const String keyCustomerId = 'customer_id';
  static const String keyCartId = 'cart_id';
  static const String keyThemeMode = 'theme_mode';
  static const String keyLanguage = 'language';
  static const String keyOnboardingCompleted = 'onboarding_completed';
  
  // Feature Flags
  static const bool enableAnalytics = true;
  static const bool enableCrashlytics = true;
  static const bool enablePushNotifications = true;
  static const bool enableBiometrics = true;
  static const bool enableOfflineMode = true;
  
  // UI Configuration
  static const double defaultPadding = 16.0;
  static const double defaultRadius = 12.0;
  static const double defaultElevation = 2.0;
  
  // Animation Durations
  static const Duration shortAnimation = Duration(milliseconds: 200);
  static const Duration mediumAnimation = Duration(milliseconds: 300);
  static const Duration longAnimation = Duration(milliseconds: 500);
  
  // Networking
  static const Duration connectionTimeout = Duration(seconds: 30);
  static const Duration receiveTimeout = Duration(seconds: 30);
  static const int maxRetries = 3;
  
  // Tax Lien Specific
  static const double minInvestmentAmount = 100.0;
  static const double maxInvestmentAmount = 1000000.0;
  static const List<String> riskLevels = ['Low', 'Medium', 'High'];
  static const List<String> propertyTypes = [
    'Residential',
    'Commercial',
    'Industrial',
    'Land',
    'Multi-family'
  ];
  
  // Image Configuration
  static const int maxImageCacheSize = 100; // MB
  static const Duration imageCacheTimeout = Duration(days: 7);
  
  // Supported Languages
  static const Map<String, String> supportedLanguages = {
    'en': 'English',
    'es': 'Español',
    'fr': 'Français',
    'de': 'Deutsch',
    'ru': 'Русский',
    'zh': '中文',
    'ja': '日本語',
    'ko': '한국어',
    'ar': 'العربية',
    'hi': 'हिंदी',
  };
  
  // Error Messages
  static const String networkErrorMessage = 'Network connection error. Please check your internet connection.';
  static const String serverErrorMessage = 'Server error. Please try again later.';
  static const String unknownErrorMessage = 'An unexpected error occurred. Please try again.';
  
  // Validation
  static const int minPasswordLength = 8;
  static const int maxNameLength = 50;
  static const String emailRegex = r'^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$';
  static const String phoneRegex = r'^\+?[\d\s\-\(\)]{10,}$';
}
