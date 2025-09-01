import 'package:flutter_test/flutter_test.dart';
import 'package:native_marketplace/core/models/app_models.dart';

void main() {
  group('ApiResponse', () {
    test('should create success response', () {
      const response = ApiResponse<String>.success(
        data: 'test data',
        message: 'Success message',
      );

      expect(response, isA<ApiResponse<String>>());
      response.when(
        success: (data, message) {
          expect(data, equals('test data'));
          expect(message, equals('Success message'));
        },
        error: (message, code, statusCode) {
          fail('Expected success response');
        },
        loading: () {
          fail('Expected success response');
        },
      );
    });

    test('should create error response', () {
      const response = ApiResponse<String>.error(
        message: 'Error occurred',
        code: 'TEST_ERROR',
        statusCode: 400,
      );

      response.when(
        success: (data, message) {
          fail('Expected error response');
        },
        error: (message, code, statusCode) {
          expect(message, equals('Error occurred'));
          expect(code, equals('TEST_ERROR'));
          expect(statusCode, equals(400));
        },
        loading: () {
          fail('Expected error response');
        },
      );
    });

    test('should create loading response', () {
      const response = ApiResponse<String>.loading();

      response.when(
        success: (data, message) {
          fail('Expected loading response');
        },
        error: (message, code, statusCode) {
          fail('Expected loading response');
        },
        loading: () {
          // Expected case
        },
      );
    });
  });

  group('AppConfig', () {
    test('should create with default values', () {
      const config = AppConfig(
        apiBaseUrl: 'https://api.example.com',
        graphqlUrl: 'https://api.example.com/graphql',
        websocketUrl: 'wss://api.example.com/ws',
      );

      expect(config.apiBaseUrl, equals('https://api.example.com'));
      expect(config.enableAnalytics, isTrue);
      expect(config.connectionTimeoutSeconds, equals(30));
      expect(config.maxRetries, equals(3));
    });

    test('should serialize to JSON', () {
      const config = AppConfig(
        apiBaseUrl: 'https://api.example.com',
        graphqlUrl: 'https://api.example.com/graphql',
        websocketUrl: 'wss://api.example.com/ws',
        enableAnalytics: false,
        connectionTimeoutSeconds: 60,
      );

      final json = config.toJson();
      expect(json['apiBaseUrl'], equals('https://api.example.com'));
      expect(json['enableAnalytics'], isFalse);
      expect(json['connectionTimeoutSeconds'], equals(60));
    });

    test('should deserialize from JSON', () {
      final json = {
        'apiBaseUrl': 'https://api.example.com',
        'graphqlUrl': 'https://api.example.com/graphql',
        'websocketUrl': 'wss://api.example.com/ws',
        'enableAnalytics': false,
        'connectionTimeoutSeconds': 60,
      };

      final config = AppConfig.fromJson(json);
      expect(config.apiBaseUrl, equals('https://api.example.com'));
      expect(config.enableAnalytics, isFalse);
      expect(config.connectionTimeoutSeconds, equals(60));
    });
  });

  group('UserPreferences', () {
    test('should create with default values', () {
      const preferences = UserPreferences();

      expect(preferences.languageCode, equals('en'));
      expect(preferences.themeMode, equals('system'));
      expect(preferences.enableNotifications, isTrue);
      expect(preferences.currency, equals('USD'));
    });

    test('should support copyWith', () {
      const preferences = UserPreferences();
      final updated = preferences.copyWith(
        languageCode: 'es',
        enableNotifications: false,
      );

      expect(updated.languageCode, equals('es'));
      expect(updated.enableNotifications, isFalse);
      expect(updated.themeMode, equals('system')); // Unchanged
    });
  });

  group('NetworkStatus', () {
    test('should create connected WiFi status', () {
      const status = NetworkStatus(
        isConnected: true,
        isWiFi: true,
        connectionType: 'WiFi',
      );

      expect(status.isConnected, isTrue);
      expect(status.isWiFi, isTrue);
      expect(status.isMobile, isFalse);
      expect(status.connectionType, equals('WiFi'));
    });

    test('should create disconnected status', () {
      const status = NetworkStatus(
        isConnected: false,
        connectionType: 'None',
      );

      expect(status.isConnected, isFalse);
      expect(status.isWiFi, isFalse);
      expect(status.isMobile, isFalse);
    });
  });

  group('PaginationInfo', () {
    test('should calculate hasNextPage correctly', () {
      const pagination = PaginationInfo(
        currentPage: 2,
        totalPages: 5,
        totalCount: 100,
      );

      expect(pagination.hasNextPage, isTrue);
      expect(pagination.hasPreviousPage, isTrue);
    });

    test('should handle first page', () {
      const pagination = PaginationInfo(
        currentPage: 1,
        totalPages: 5,
      );

      expect(pagination.hasNextPage, isTrue);
      expect(pagination.hasPreviousPage, isFalse);
    });

    test('should handle last page', () {
      const pagination = PaginationInfo(
        currentPage: 5,
        totalPages: 5,
      );

      expect(pagination.hasNextPage, isFalse);
      expect(pagination.hasPreviousPage, isTrue);
    });
  });

  group('CacheEntry', () {
    test('should store data with timestamp', () {
      final entry = CacheEntry(
        data: 'test data',
        timestamp: DateTime.now(),
        ttlSeconds: 3600,
      );

      expect(entry.data, equals('test data'));
      expect(entry.ttlSeconds, equals(3600));
      expect(entry.timestamp, isA<DateTime>());
    });
  });

  group('ErrorDetails', () {
    test('should create with required fields', () {
      const error = ErrorDetails(
        message: 'Something went wrong',
        code: 'ERROR_CODE',
        statusCode: 500,
      );

      expect(error.message, equals('Something went wrong'));
      expect(error.code, equals('ERROR_CODE'));
      expect(error.statusCode, equals(500));
    });

    test('should support optional fields', () {
      final timestamp = DateTime.now();
      final error = ErrorDetails(
        message: 'Something went wrong',
        details: 'Additional details',
        timestamp: timestamp,
        metadata: {'key': 'value'},
      );

      expect(error.details, equals('Additional details'));
      expect(error.timestamp, equals(timestamp));
      expect(error.metadata, equals({'key': 'value'}));
    });
  });
}
