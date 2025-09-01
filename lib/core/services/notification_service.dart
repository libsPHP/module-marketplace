import 'package:flutter/foundation.dart';
import 'package:flutter_local_notifications/flutter_local_notifications.dart';
import 'package:firebase_messaging/firebase_messaging.dart';
import 'package:permission_handler/permission_handler.dart';

/// Service for handling local and push notifications
class NotificationService {
  static final FlutterLocalNotificationsPlugin _localNotifications =
      FlutterLocalNotificationsPlugin();
  static FirebaseMessaging? _messaging;
  static bool _isInitialized = false;
  static String? _fcmToken;

  /// Initialize notification service
  static Future<void> initialize() async {
    try {
      await _initializeLocalNotifications();
      await _initializePushNotifications();
      _isInitialized = true;
      
      if (kDebugMode) {
        print('🔔 Notification service initialized');
      }
    } catch (e) {
      if (kDebugMode) {
        print('❌ Error initializing notifications: $e');
      }
    }
  }

  /// Initialize local notifications
  static Future<void> _initializeLocalNotifications() async {
    const androidSettings = AndroidInitializationSettings('@mipmap/ic_launcher');
    const iosSettings = DarwinInitializationSettings(
      requestAlertPermission: false,
      requestBadgePermission: false,
      requestSoundPermission: false,
    );
    
    const initSettings = InitializationSettings(
      android: androidSettings,
      iOS: iosSettings,
      macOS: iosSettings,
    );

    await _localNotifications.initialize(
      initSettings,
      onDidReceiveNotificationResponse: _onNotificationTapped,
    );

    // Request permissions
    await _requestPermissions();
  }

  /// Initialize push notifications
  static Future<void> _initializePushNotifications() async {
    if (!kReleaseMode) {
      if (kDebugMode) {
        print('🔔 Push notifications disabled in debug mode');
      }
      return;
    }

    try {
      _messaging = FirebaseMessaging.instance;

      // Request permission
      final settings = await _messaging!.requestPermission(
        alert: true,
        badge: true,
        sound: true,
        provisional: false,
      );

      if (settings.authorizationStatus == AuthorizationStatus.authorized) {
        if (kDebugMode) {
          print('🔔 Push notification permission granted');
        }

        // Get FCM token
        _fcmToken = await _messaging!.getToken();
        if (kDebugMode) {
          print('🔑 FCM Token: $_fcmToken');
        }

        // Listen for token refresh
        _messaging!.onTokenRefresh.listen((token) {
          _fcmToken = token;
          if (kDebugMode) {
            print('🔄 FCM Token refreshed: $token');
          }
        });

        // Handle foreground messages
        FirebaseMessaging.onMessage.listen(_handleForegroundMessage);

        // Handle background messages
        FirebaseMessaging.onBackgroundMessage(_handleBackgroundMessage);

        // Handle notification taps when app is in background or terminated
        FirebaseMessaging.onMessageOpenedApp.listen(_handleNotificationTap);

        // Check for initial message (when app is launched from notification)
        final initialMessage = await _messaging!.getInitialMessage();
        if (initialMessage != null) {
          _handleNotificationTap(initialMessage);
        }
      } else {
        if (kDebugMode) {
          print('⚠️ Push notification permission denied');
        }
      }
    } catch (e) {
      if (kDebugMode) {
        print('❌ Error initializing push notifications: $e');
      }
    }
  }

  /// Request notification permissions
  static Future<void> _requestPermissions() async {
    if (defaultTargetPlatform == TargetPlatform.iOS ||
        defaultTargetPlatform == TargetPlatform.macOS) {
      await _localNotifications
          .resolvePlatformSpecificImplementation<
              IOSFlutterLocalNotificationsPlugin>()
          ?.requestPermissions(
            alert: true,
            badge: true,
            sound: true,
          );
    } else if (defaultTargetPlatform == TargetPlatform.android) {
      await Permission.notification.request();
    }
  }

  /// Handle foreground messages
  static Future<void> _handleForegroundMessage(RemoteMessage message) async {
    if (kDebugMode) {
      print('📱 Foreground message: ${message.notification?.title}');
    }

    // Show local notification for foreground messages
    if (message.notification != null) {
      await showNotification(
        title: message.notification!.title ?? 'TaxLien.online',
        body: message.notification!.body ?? '',
        payload: message.data.toString(),
      );
    }
  }

  /// Handle background messages
  @pragma('vm:entry-point')
  static Future<void> _handleBackgroundMessage(RemoteMessage message) async {
    if (kDebugMode) {
      print('📱 Background message: ${message.notification?.title}');
    }
  }

  /// Handle notification tap
  static void _handleNotificationTap(RemoteMessage message) {
    if (kDebugMode) {
      print('🔔 Notification tapped: ${message.data}');
    }
    // Handle navigation based on message data
    // This would typically involve using a global navigator or routing service
  }

  /// Handle local notification tap
  static void _onNotificationTapped(NotificationResponse response) {
    if (kDebugMode) {
      print('🔔 Local notification tapped: ${response.payload}');
    }
    // Handle navigation based on payload
  }

  /// Show a local notification
  static Future<void> showNotification({
    int id = 0,
    required String title,
    required String body,
    String? payload,
    NotificationDetails? notificationDetails,
  }) async {
    if (!_isInitialized) return;

    try {
      notificationDetails ??= const NotificationDetails(
        android: AndroidNotificationDetails(
          'default_channel',
          'Default',
          channelDescription: 'Default notification channel',
          importance: Importance.defaultImportance,
          priority: Priority.defaultPriority,
          icon: '@mipmap/ic_launcher',
        ),
        iOS: DarwinNotificationDetails(
          presentAlert: true,
          presentBadge: true,
          presentSound: true,
        ),
      );

      await _localNotifications.show(
        id,
        title,
        body,
        notificationDetails,
        payload: payload,
      );

      if (kDebugMode) {
        print('🔔 Local notification shown: $title');
      }
    } catch (e) {
      if (kDebugMode) {
        print('❌ Error showing notification: $e');
      }
    }
  }

  /// Schedule a notification
  static Future<void> scheduleNotification({
    required int id,
    required String title,
    required String body,
    required DateTime scheduledDate,
    String? payload,
    NotificationDetails? notificationDetails,
  }) async {
    if (!_isInitialized) return;

    try {
      notificationDetails ??= const NotificationDetails(
        android: AndroidNotificationDetails(
          'scheduled_channel',
          'Scheduled',
          channelDescription: 'Scheduled notification channel',
          importance: Importance.defaultImportance,
          priority: Priority.defaultPriority,
          icon: '@mipmap/ic_launcher',
        ),
        iOS: DarwinNotificationDetails(
          presentAlert: true,
          presentBadge: true,
          presentSound: true,
        ),
      );

      await _localNotifications.schedule(
        id,
        title,
        body,
        scheduledDate,
        notificationDetails,
        payload: payload,
        androidScheduleMode: AndroidScheduleMode.exactAllowWhileIdle,
        uiLocalNotificationDateInterpretation:
            UILocalNotificationDateInterpretation.absoluteTime,
      );

      if (kDebugMode) {
        print('⏰ Notification scheduled: $title for $scheduledDate');
      }
    } catch (e) {
      if (kDebugMode) {
        print('❌ Error scheduling notification: $e');
      }
    }
  }

  /// Cancel a notification
  static Future<void> cancelNotification(int id) async {
    if (!_isInitialized) return;

    try {
      await _localNotifications.cancel(id);
      if (kDebugMode) {
        print('🗑️ Notification cancelled: $id');
      }
    } catch (e) {
      if (kDebugMode) {
        print('❌ Error cancelling notification: $e');
      }
    }
  }

  /// Cancel all notifications
  static Future<void> cancelAllNotifications() async {
    if (!_isInitialized) return;

    try {
      await _localNotifications.cancelAll();
      if (kDebugMode) {
        print('🗑️ All notifications cancelled');
      }
    } catch (e) {
      if (kDebugMode) {
        print('❌ Error cancelling all notifications: $e');
      }
    }
  }

  /// Get pending notifications
  static Future<List<PendingNotificationRequest>> getPendingNotifications() async {
    if (!_isInitialized) return [];

    try {
      return await _localNotifications.pendingNotificationRequests();
    } catch (e) {
      if (kDebugMode) {
        print('❌ Error getting pending notifications: $e');
      }
      return [];
    }
  }

  /// Subscribe to FCM topic
  static Future<void> subscribeToTopic(String topic) async {
    if (_messaging != null) {
      try {
        await _messaging!.subscribeToTopic(topic);
        if (kDebugMode) {
          print('📡 Subscribed to topic: $topic');
        }
      } catch (e) {
        if (kDebugMode) {
          print('❌ Error subscribing to topic: $e');
        }
      }
    }
  }

  /// Unsubscribe from FCM topic
  static Future<void> unsubscribeFromTopic(String topic) async {
    if (_messaging != null) {
      try {
        await _messaging!.unsubscribeFromTopic(topic);
        if (kDebugMode) {
          print('📡 Unsubscribed from topic: $topic');
        }
      } catch (e) {
        if (kDebugMode) {
          print('❌ Error unsubscribing from topic: $e');
        }
      }
    }
  }

  /// Get FCM token
  static String? get fcmToken => _fcmToken;

  /// Check if notifications are initialized
  static bool get isInitialized => _isInitialized;

  /// Show investment reminder notification
  static Future<void> showInvestmentReminder({
    required String propertyAddress,
    required DateTime auctionDate,
  }) async {
    await showNotification(
      id: DateTime.now().millisecondsSinceEpoch.remainder(100000),
      title: '🏠 Investment Opportunity',
      body: 'Don\'t miss the auction for $propertyAddress on ${auctionDate.day}/${auctionDate.month}',
      payload: 'investment_reminder',
    );
  }

  /// Show price alert notification
  static Future<void> showPriceAlert({
    required String propertyAddress,
    required double newPrice,
  }) async {
    await showNotification(
      id: DateTime.now().millisecondsSinceEpoch.remainder(100000),
      title: '💰 Price Alert',
      body: 'Price updated for $propertyAddress: \$${newPrice.toStringAsFixed(2)}',
      payload: 'price_alert',
    );
  }

  /// Show portfolio update notification
  static Future<void> showPortfolioUpdate({
    required String updateType,
    required String details,
  }) async {
    await showNotification(
      id: DateTime.now().millisecondsSinceEpoch.remainder(100000),
      title: '📊 Portfolio Update',
      body: '$updateType: $details',
      payload: 'portfolio_update',
    );
  }
}
