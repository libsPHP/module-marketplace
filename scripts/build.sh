#!/bin/bash

# Build script for Native Marketplace
# Usage: ./scripts/build.sh [android|ios|web] [debug|profile|release]

set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Default values
PLATFORM=""
BUILD_MODE="release"
APP_VERSION="1.0.0"
BUILD_NUMBER=$(date +%s)

print_usage() {
    echo "Usage: $0 [platform] [build_mode]"
    echo "Platforms: android, ios, web, all"
    echo "Build modes: debug, profile, release (default: release)"
    echo ""
    echo "Examples:"
    echo "  $0 android release"
    echo "  $0 ios profile"
    echo "  $0 web"
    echo "  $0 all release"
}

log() {
    echo -e "${GREEN}[$(date +'%Y-%m-%d %H:%M:%S')] $1${NC}"
}

warn() {
    echo -e "${YELLOW}[WARNING] $1${NC}"
}

error() {
    echo -e "${RED}[ERROR] $1${NC}"
    exit 1
}

# Parse arguments
if [ $# -eq 0 ]; then
    print_usage
    exit 1
fi

PLATFORM=$1
BUILD_MODE=${2:-release}

# Validate build mode
if [[ ! "$BUILD_MODE" =~ ^(debug|profile|release)$ ]]; then
    error "Invalid build mode: $BUILD_MODE"
fi

log "🚀 Starting build for $PLATFORM in $BUILD_MODE mode"
log "📱 App version: $APP_VERSION+$BUILD_NUMBER"

# Check Flutter installation
if ! command -v flutter &> /dev/null; then
    error "Flutter is not installed or not in PATH"
fi

# Check Flutter doctor
log "🔍 Checking Flutter installation..."
flutter doctor

# Clean previous builds
log "🧹 Cleaning previous builds..."
flutter clean

# Get dependencies
log "📦 Getting dependencies..."
flutter pub get

# Generate code
log "🔧 Generating code..."
flutter packages pub run build_runner build --delete-conflicting-outputs

# Generate localizations
log "🌐 Generating localizations..."
flutter gen-l10n

# Build function
build_android() {
    log "🤖 Building Android APK and Bundle..."
    
    if [ "$BUILD_MODE" = "release" ]; then
        # Build release APK
        flutter build apk \
            --release \
            --build-name=$APP_VERSION \
            --build-number=$BUILD_NUMBER \
            --target-platform android-arm,android-arm64 \
            --split-per-abi
        
        # Build release Bundle
        flutter build appbundle \
            --release \
            --build-name=$APP_VERSION \
            --build-number=$BUILD_NUMBER
            
        log "✅ Android build completed"
        log "📁 APK: build/app/outputs/flutter-apk/"
        log "📁 Bundle: build/app/outputs/bundle/release/"
    else
        flutter build apk \
            --$BUILD_MODE \
            --build-name=$APP_VERSION \
            --build-number=$BUILD_NUMBER
        
        log "✅ Android $BUILD_MODE build completed"
        log "📁 APK: build/app/outputs/flutter-apk/"
    fi
}

build_ios() {
    if [[ "$OSTYPE" != "darwin"* ]]; then
        error "iOS builds are only supported on macOS"
    fi
    
    log "🍎 Building iOS..."
    
    # Install pods
    log "📦 Installing CocoaPods dependencies..."
    cd ios && pod install && cd ..
    
    if [ "$BUILD_MODE" = "release" ]; then
        flutter build ios \
            --release \
            --build-name=$APP_VERSION \
            --build-number=$BUILD_NUMBER \
            --no-codesign
        
        log "✅ iOS release build completed"
        log "📁 Output: build/ios/iphoneos/"
        log "⚠️  Note: Code signing required for distribution"
    else
        flutter build ios \
            --$BUILD_MODE \
            --build-name=$APP_VERSION \
            --build-number=$BUILD_NUMBER \
            --no-codesign
        
        log "✅ iOS $BUILD_MODE build completed"
    fi
}

build_web() {
    log "🌐 Building Web..."
    
    flutter build web \
        --$BUILD_MODE \
        --build-name=$APP_VERSION \
        --build-number=$BUILD_NUMBER \
        --web-renderer canvaskit \
        --base-href "/"
    
    log "✅ Web build completed"
    log "📁 Output: build/web/"
}

# Execute builds based on platform
case $PLATFORM in
    android)
        build_android
        ;;
    ios)
        build_ios
        ;;
    web)
        build_web
        ;;
    all)
        build_android
        build_ios
        build_web
        ;;
    *)
        error "Unknown platform: $PLATFORM"
        ;;
esac

# Generate checksums for release builds
if [ "$BUILD_MODE" = "release" ]; then
    log "🔐 Generating checksums..."
    
    if [ "$PLATFORM" = "android" ] || [ "$PLATFORM" = "all" ]; then
        if [ -f "build/app/outputs/bundle/release/app-release.aab" ]; then
            sha256sum build/app/outputs/bundle/release/app-release.aab > build/app/outputs/bundle/release/app-release.aab.sha256
        fi
        
        for apk in build/app/outputs/flutter-apk/app-*-release.apk; do
            if [ -f "$apk" ]; then
                sha256sum "$apk" > "$apk.sha256"
            fi
        done
    fi
    
    if [ "$PLATFORM" = "web" ] || [ "$PLATFORM" = "all" ]; then
        if [ -d "build/web" ]; then
            tar -czf "build/web-$APP_VERSION+$BUILD_NUMBER.tar.gz" -C build web
            sha256sum "build/web-$APP_VERSION+$BUILD_NUMBER.tar.gz" > "build/web-$APP_VERSION+$BUILD_NUMBER.tar.gz.sha256"
        fi
    fi
fi

# Run tests for release builds
if [ "$BUILD_MODE" = "release" ]; then
    log "🧪 Running tests..."
    flutter test
    
    log "🔍 Analyzing code..."
    flutter analyze
fi

log "🎉 Build completed successfully!"
log "📊 Build summary:"
log "   Platform: $PLATFORM"
log "   Mode: $BUILD_MODE"
log "   Version: $APP_VERSION+$BUILD_NUMBER"
log "   Time: $(date)"

# Show output locations
case $PLATFORM in
    android|all)
        log "📁 Android outputs:"
        log "   APK: build/app/outputs/flutter-apk/"
        log "   Bundle: build/app/outputs/bundle/release/"
        ;;
esac

case $PLATFORM in
    ios|all)
        if [[ "$OSTYPE" == "darwin"* ]]; then
            log "📁 iOS outputs:"
            log "   IPA: build/ios/iphoneos/"
        fi
        ;;
esac

case $PLATFORM in
    web|all)
        log "📁 Web outputs:"
        log "   Static files: build/web/"
        ;;
esac

log "✨ Build script completed!"
