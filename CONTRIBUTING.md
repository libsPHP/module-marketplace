# Contributing to NativeMind Marketplace Module

Thank you for your interest in contributing to the NativeMind Marketplace module for Magento 2! This document provides guidelines and information for contributors.

## 🚀 Getting Started

### Prerequisites

- **Magento 2.4.x** (2.4.0 or higher)
- **PHP 7.4+** (8.1+ recommended)
- **Composer** for dependency management
- **Git** for version control
- **PHPUnit** for testing

### Development Setup

1. **Fork the repository**
   ```bash
   git clone https://github.com/your-username/module-marketplace.git
   cd module-marketplace
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Run tests**
   ```bash
   vendor/bin/phpunit
   ```

## 📝 Contribution Guidelines

### Code Standards

- Follow **PSR-12** coding standards
- Use **PHP 7.4+** features where appropriate
- Write **comprehensive tests** for new features
- Document all **public APIs**
- Follow **Magento 2 coding standards**

### Commit Messages

Use clear, descriptive commit messages:

```
feat: add seller approval workflow
fix: resolve subdomain validation issue
docs: update installation instructions
test: add unit tests for product management
```

### Pull Request Process

1. **Create a feature branch**
   ```bash
   git checkout -b feature/your-feature-name
   ```

2. **Make your changes**
   - Write tests for new functionality
   - Update documentation if needed
   - Ensure all tests pass

3. **Submit a pull request**
   - Provide a clear description
   - Reference any related issues
   - Include screenshots for UI changes

## 🧪 Testing

### Running Tests

```bash
# Run all tests
vendor/bin/phpunit

# Run specific test suite
vendor/bin/phpunit --testsuite=NativeMind_Marketplace_Unit

# Run with coverage
vendor/bin/phpunit --coverage-html coverage/
```

### Writing Tests

- **Unit Tests**: Test individual classes and methods
- **Integration Tests**: Test module integration with Magento
- **API Tests**: Test REST/GraphQL endpoints

### Test Coverage

- Aim for **80%+ code coverage**
- Test all public methods
- Test edge cases and error conditions

## 📚 Documentation

### Code Documentation

- Use **PHPDoc** for all classes and methods
- Include **@param** and **@return** annotations
- Provide **@throws** for exceptions

### API Documentation

- Document all **REST API endpoints**
- Include **request/response examples**
- Provide **authentication requirements**

## 🐛 Bug Reports

When reporting bugs, please include:

1. **Magento version** and **PHP version**
2. **Steps to reproduce** the issue
3. **Expected vs actual behavior**
4. **Error logs** and **stack traces**
5. **Screenshots** if applicable

## 💡 Feature Requests

When requesting features, please include:

1. **Use case** and **business value**
2. **Detailed description** of the feature
3. **Proposed implementation** approach
4. **Backward compatibility** considerations

## 🔧 Development Workflow

### Branch Naming

- `feature/feature-name` - New features
- `bugfix/bug-description` - Bug fixes
- `hotfix/critical-fix` - Critical fixes
- `docs/documentation-update` - Documentation

### Code Review Process

1. **Self-review** your changes
2. **Run tests** and ensure they pass
3. **Update documentation** if needed
4. **Request review** from maintainers

## 📋 Issue Templates

### Bug Report Template

```markdown
## Bug Description
Brief description of the bug

## Steps to Reproduce
1. Step one
2. Step two
3. Step three

## Expected Behavior
What should happen

## Actual Behavior
What actually happens

## Environment
- Magento Version: 2.4.x
- PHP Version: 7.4+
- Module Version: 1.0.0

## Additional Context
Any other relevant information
```

### Feature Request Template

```markdown
## Feature Description
Brief description of the feature

## Use Case
Why is this feature needed?

## Proposed Solution
How should this feature work?

## Alternatives Considered
Other approaches you've considered

## Additional Context
Any other relevant information
```

## 🏗️ Architecture Guidelines

### Module Structure

```
app/code/NativeMind/Marketplace/
├── Api/                    # API interfaces
├── Block/                  # View blocks
├── Controller/             # Controllers
├── Helper/                 # Helper classes
├── Model/                  # Data models
├── Observer/               # Event observers
├── Plugin/                 # Plugin classes
├── Setup/                  # Install/upgrade scripts
├── view/                   # Templates and layouts
└── etc/                    # Configuration files
```

### Design Patterns

- **Repository Pattern** for data access
- **Factory Pattern** for object creation
- **Observer Pattern** for event handling
- **Plugin Pattern** for extending functionality

## 🚀 Release Process

### Version Numbering

- **Major** (1.0.0): Breaking changes
- **Minor** (1.1.0): New features, backward compatible
- **Patch** (1.0.1): Bug fixes, backward compatible

### Release Checklist

- [ ] All tests pass
- [ ] Documentation updated
- [ ] Changelog updated
- [ ] Version bumped
- [ ] Tagged in Git

## 📞 Support

- **GitHub Issues**: For bugs and feature requests
- **Email**: support@nativemind.net
- **Documentation**: [docs.nativemind.net](https://docs.nativemind.net)

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🙏 Acknowledgments

Thank you to all contributors who help make this project better!

---

**Happy coding!** 🎉

