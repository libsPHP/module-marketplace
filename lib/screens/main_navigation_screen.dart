import 'package:flutter/material.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';

import '../core/services/analytics_service.dart';
import '../features/marketplace/screens/marketplace_screen.dart';
import '../features/auth/screens/profile_screen.dart';
import 'home_screen.dart';
import 'cart_screen.dart';
import 'search_screen.dart';

/// Main navigation screen with bottom navigation bar
class MainNavigationScreen extends ConsumerStatefulWidget {
  const MainNavigationScreen({super.key});

  @override
  ConsumerState<MainNavigationScreen> createState() => _MainNavigationScreenState();
}

class _MainNavigationScreenState extends ConsumerState<MainNavigationScreen> {
  int _selectedIndex = 0;
  late PageController _pageController;

  @override
  void initState() {
    super.initState();
    _pageController = PageController();
    AnalyticsService.trackScreenView('main_navigation');
  }

  @override
  void dispose() {
    _pageController.dispose();
    super.dispose();
  }

  void _onItemTapped(int index) {
    if (_selectedIndex != index) {
      setState(() {
        _selectedIndex = index;
      });
      
      _pageController.animateToPage(
        index,
        duration: const Duration(milliseconds: 300),
        curve: Curves.easeInOut,
      );

      // Track navigation
      final screenNames = ['home', 'marketplace', 'search', 'cart', 'profile'];
      AnalyticsService.trackScreenView(screenNames[index]);
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: PageView(
        controller: _pageController,
        onPageChanged: (index) {
          setState(() {
            _selectedIndex = index;
          });
        },
        children: const [
          HomeScreen(),
          MarketplaceScreen(),
          SearchScreen(),
          CartScreen(),
          ProfileScreen(),
        ],
      ),
      bottomNavigationBar: BottomNavigationBar(
        type: BottomNavigationBarType.fixed,
        currentIndex: _selectedIndex,
        onTap: _onItemTapped,
        elevation: 8,
        items: [
          BottomNavigationBarItem(
            icon: Icon(
              _selectedIndex == 0 ? Icons.home : Icons.home_outlined,
            ),
            label: 'Home',
          ),
          BottomNavigationBarItem(
            icon: Icon(
              _selectedIndex == 1 ? Icons.store : Icons.store_outlined,
            ),
            label: 'Marketplace',
          ),
          BottomNavigationBarItem(
            icon: Icon(
              _selectedIndex == 2 ? Icons.search : Icons.search_outlined,
            ),
            label: 'Search',
          ),
          BottomNavigationBarItem(
            icon: Stack(
              clipBehavior: Clip.none,
              children: [
                Icon(
                  _selectedIndex == 3 ? Icons.shopping_cart : Icons.shopping_cart_outlined,
                ),
                // Cart badge - you can implement this with cart provider
                // Positioned(
                //   right: -6,
                //   top: -6,
                //   child: Consumer(
                //     builder: (context, ref, child) {
                //       final cartState = ref.watch(cartProvider);
                //       if (cartState.itemCount > 0) {
                //         return Container(
                //           padding: const EdgeInsets.all(2),
                //           decoration: BoxDecoration(
                //             color: Theme.of(context).colorScheme.error,
                //             borderRadius: BorderRadius.circular(10),
                //           ),
                //           constraints: const BoxConstraints(
                //             minWidth: 16,
                //             minHeight: 16,
                //           ),
                //           child: Text(
                //             '${cartState.itemCount}',
                //             style: TextStyle(
                //               color: Theme.of(context).colorScheme.onError,
                //               fontSize: 10,
                //               fontWeight: FontWeight.bold,
                //             ),
                //             textAlign: TextAlign.center,
                //           ),
                //         );
                //       }
                //       return const SizedBox.shrink();
                //     },
                //   ),
                // ),
              ],
            ),
            label: 'Cart',
          ),
          BottomNavigationBarItem(
            icon: Icon(
              _selectedIndex == 4 ? Icons.person : Icons.person_outline,
            ),
            label: 'Profile',
          ),
        ],
      ),
    );
  }
}

/// Custom navigation bar item with animation
class AnimatedNavigationItem extends StatelessWidget {
  final IconData icon;
  final IconData selectedIcon;
  final String label;
  final bool isSelected;
  final VoidCallback onTap;

  const AnimatedNavigationItem({
    super.key,
    required this.icon,
    required this.selectedIcon,
    required this.label,
    required this.isSelected,
    required this.onTap,
  });

  @override
  Widget build(BuildContext context) {
    return InkWell(
      onTap: onTap,
      borderRadius: BorderRadius.circular(12),
      child: AnimatedContainer(
        duration: const Duration(milliseconds: 200),
        padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
        decoration: BoxDecoration(
          color: isSelected 
              ? Theme.of(context).colorScheme.primary.withOpacity(0.1)
              : Colors.transparent,
          borderRadius: BorderRadius.circular(12),
        ),
        child: Column(
          mainAxisSize: MainAxisSize.min,
          children: [
            AnimatedSwitcher(
              duration: const Duration(milliseconds: 200),
              child: Icon(
                isSelected ? selectedIcon : icon,
                key: ValueKey(isSelected),
                color: isSelected 
                    ? Theme.of(context).colorScheme.primary
                    : Theme.of(context).colorScheme.onSurfaceVariant,
                size: 24,
              ),
            ),
            const SizedBox(height: 4),
            AnimatedDefaultTextStyle(
              duration: const Duration(milliseconds: 200),
              style: TextStyle(
                fontSize: 12,
                fontWeight: isSelected ? FontWeight.w600 : FontWeight.w500,
                color: isSelected 
                    ? Theme.of(context).colorScheme.primary
                    : Theme.of(context).colorScheme.onSurfaceVariant,
              ),
              child: Text(label),
            ),
          ],
        ),
      ),
    );
  }
}

/// Custom bottom navigation bar with modern design
class ModernBottomNavigationBar extends StatelessWidget {
  final int currentIndex;
  final Function(int) onTap;
  final List<BottomNavigationBarItem> items;

  const ModernBottomNavigationBar({
    super.key,
    required this.currentIndex,
    required this.onTap,
    required this.items,
  });

  @override
  Widget build(BuildContext context) {
    return Container(
      decoration: BoxDecoration(
        color: Theme.of(context).colorScheme.surface,
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.1),
            blurRadius: 10,
            offset: const Offset(0, -2),
          ),
        ],
      ),
      child: SafeArea(
        child: Padding(
          padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
          child: Row(
            mainAxisAlignment: MainAxisAlignment.spaceAround,
            children: items.asMap().entries.map((entry) {
              final index = entry.key;
              final item = entry.value;
              
              return Expanded(
                child: AnimatedNavigationItem(
                  icon: item.icon is Icon ? (item.icon as Icon).icon! : Icons.help,
                  selectedIcon: item.activeIcon is Icon 
                      ? (item.activeIcon as Icon).icon! 
                      : (item.icon is Icon ? (item.icon as Icon).icon! : Icons.help),
                  label: item.label ?? '',
                  isSelected: currentIndex == index,
                  onTap: () => onTap(index),
                ),
              );
            }).toList(),
          ),
        ),
      ),
    );
  }
}
