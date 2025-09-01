#!/bin/bash

# Deployment script for Native Marketplace
# Usage: ./scripts/deploy.sh [environment] [platform]

set -e

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

# Configuration
ENVIRONMENT=${1:-staging}
PLATFORM=${2:-android}
APP_VERSION="1.0.0"
BUILD_NUMBER=$(date +%s)

# Environment configurations
declare -A ENV_CONFIGS
ENV_CONFIGS[staging]="staging.taxlien.online"
ENV_CONFIGS[production]="taxlien.online"

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

print_usage() {
    echo "Usage: $0 [environment] [platform]"
    echo "Environments: staging, production"
    echo "Platforms: android, ios, web"
    echo ""
    echo "Examples:"
    echo "  $0 staging android"
    echo "  $0 production ios"
    echo "  $0 staging web"
}

# Validate environment
if [[ ! "${!ENV_CONFIGS[@]}" =~ "$ENVIRONMENT" ]]; then
    error "Invalid environment: $ENVIRONMENT. Supported: ${!ENV_CONFIGS[@]}"
fi

# Validate platform
if [[ ! "$PLATFORM" =~ ^(android|ios|web)$ ]]; then
    error "Invalid platform: $PLATFORM"
fi

log "🚀 Starting deployment to $ENVIRONMENT for $PLATFORM"

# Pre-deployment checks
log "🔍 Running pre-deployment checks..."

# Check if we're on the correct branch
CURRENT_BRANCH=$(git rev-parse --abbrev-ref HEAD)
if [[ "$ENVIRONMENT" == "production" && "$CURRENT_BRANCH" != "main" ]]; then
    error "Production deployments must be from 'main' branch. Current: $CURRENT_BRANCH"
fi

# Check for uncommitted changes
if [[ -n $(git status --porcelain) ]]; then
    error "There are uncommitted changes. Please commit or stash them before deploying."
fi

# Run tests
log "🧪 Running tests..."
flutter test || error "Tests failed"

# Code analysis
log "🔍 Running code analysis..."
flutter analyze || error "Code analysis failed"

# Build the app
log "🔨 Building $PLATFORM app for $ENVIRONMENT..."
case $PLATFORM in
    android)
        ./scripts/build.sh android release
        ;;
    ios)
        ./scripts/build.sh ios release
        ;;
    web)
        ./scripts/build.sh web release
        ;;
esac

# Deploy based on platform
deploy_android() {
    log "🤖 Deploying Android to $ENVIRONMENT..."
    
    if [[ "$ENVIRONMENT" == "production" ]]; then
        # Deploy to Google Play Console
        log "📱 Uploading to Google Play Console..."
        # This would use fastlane or Google Play Developer API
        # fastlane android deploy_production
        warn "Google Play Console upload requires manual action"
        log "📁 Upload file: build/app/outputs/bundle/release/app-release.aab"
    else
        # Deploy to Firebase App Distribution or internal testing
        log "🔥 Uploading to Firebase App Distribution..."
        # firebase appdistribution:distribute build/app/outputs/flutter-apk/app-release.apk \
        #     --app $FIREBASE_APP_ID \
        #     --groups "internal-testers" \
        #     --release-notes "Build $BUILD_NUMBER for $ENVIRONMENT"
        warn "Firebase App Distribution upload requires configuration"
    fi
}

deploy_ios() {
    if [[ "$OSTYPE" != "darwin"* ]]; then
        error "iOS deployment is only supported on macOS"
    fi
    
    log "🍎 Deploying iOS to $ENVIRONMENT..."
    
    if [[ "$ENVIRONMENT" == "production" ]]; then
        # Deploy to App Store Connect
        log "📱 Uploading to App Store Connect..."
        # This would use fastlane or altool
        # fastlane ios deploy_production
        warn "App Store Connect upload requires manual action"
        log "📁 Archive location: build/ios/iphoneos/"
    else
        # Deploy to TestFlight or Firebase App Distribution
        log "✈️ Uploading to TestFlight..."
        # fastlane ios deploy_staging
        warn "TestFlight upload requires configuration"
    fi
}

deploy_web() {
    log "🌐 Deploying Web to $ENVIRONMENT..."
    
    local target_url=${ENV_CONFIGS[$ENVIRONMENT]}
    
    # Deploy to CDN or hosting service
    case $ENVIRONMENT in
        staging)
            # Deploy to staging server
            log "📤 Uploading to staging server..."
            # rsync -avz build/web/ user@staging.server:/var/www/html/
            # Or use AWS S3, Firebase Hosting, etc.
            warn "Web deployment to staging requires server configuration"
            ;;
        production)
            # Deploy to production
            log "📤 Uploading to production server..."
            # This could be:
            # - AWS S3 + CloudFront
            # - Firebase Hosting
            # - Vercel
            # - Netlify
            warn "Web deployment to production requires hosting service configuration"
            ;;
    esac
    
    log "🔗 Deployment URL: https://$target_url"
}

# Execute deployment
case $PLATFORM in
    android)
        deploy_android
        ;;
    ios)
        deploy_ios
        ;;
    web)
        deploy_web
        ;;
esac

# Post-deployment tasks
log "📋 Running post-deployment tasks..."

# Create deployment record
DEPLOYMENT_INFO=$(cat <<EOF
{
  "timestamp": "$(date -u +%Y-%m-%dT%H:%M:%SZ)",
  "environment": "$ENVIRONMENT",
  "platform": "$PLATFORM",
  "version": "$APP_VERSION",
  "build_number": "$BUILD_NUMBER",
  "branch": "$CURRENT_BRANCH",
  "commit": "$(git rev-parse HEAD)",
  "deployed_by": "$(git config user.name)"
}
EOF
)

echo "$DEPLOYMENT_INFO" > "deployment-$ENVIRONMENT-$PLATFORM-$BUILD_NUMBER.json"
log "📝 Deployment record saved: deployment-$ENVIRONMENT-$PLATFORM-$BUILD_NUMBER.json"

# Send notifications (optional)
send_notifications() {
    if [[ "$ENVIRONMENT" == "production" ]]; then
        # Send Slack notification
        # curl -X POST -H 'Content-type: application/json' \
        #     --data '{"text":"🚀 Native Marketplace v'$APP_VERSION' deployed to production ('$PLATFORM')"}' \
        #     $SLACK_WEBHOOK_URL
        
        # Send email notification
        # echo "Production deployment completed" | mail -s "Deployment Notification" team@taxlien.online
        
        log "📢 Production deployment notifications sent"
    fi
}

# Tag release for production
if [[ "$ENVIRONMENT" == "production" ]]; then
    TAG_NAME="v$APP_VERSION-$PLATFORM"
    git tag -a "$TAG_NAME" -m "Release $APP_VERSION for $PLATFORM"
    git push origin "$TAG_NAME"
    log "🏷️ Created release tag: $TAG_NAME"
fi

send_notifications

log "✅ Deployment completed successfully!"
log "📊 Deployment Summary:"
log "   Environment: $ENVIRONMENT"
log "   Platform: $PLATFORM"
log "   Version: $APP_VERSION+$BUILD_NUMBER"
log "   Branch: $CURRENT_BRANCH"
log "   Commit: $(git rev-parse --short HEAD)"
log "   Time: $(date)"

# Show next steps
log "🎯 Next Steps:"
case $PLATFORM in
    android)
        if [[ "$ENVIRONMENT" == "production" ]]; then
            log "   1. Upload AAB to Google Play Console"
            log "   2. Fill release notes and submit for review"
            log "   3. Monitor crash reports and user feedback"
        else
            log "   1. Notify QA team for testing"
            log "   2. Share download link with stakeholders"
        fi
        ;;
    ios)
        if [[ "$ENVIRONMENT" == "production" ]]; then
            log "   1. Upload IPA to App Store Connect"
            log "   2. Submit for App Store review"
            log "   3. Monitor TestFlight feedback"
        else
            log "   1. Share TestFlight link with testers"
            log "   2. Collect feedback and bug reports"
        fi
        ;;
    web)
        log "   1. Verify deployment at https://${ENV_CONFIGS[$ENVIRONMENT]}"
        log "   2. Run smoke tests on deployed version"
        log "   3. Update DNS if needed"
        ;;
esac

log "🎉 Deployment script completed!"
