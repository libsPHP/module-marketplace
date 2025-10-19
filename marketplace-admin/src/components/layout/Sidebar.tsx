import { NavLink } from 'react-router-dom'
import {
  LayoutDashboard,
  Users,
  Package,
  MessageSquare,
  Star,
  Clock,
} from 'lucide-react'

const menuItems = [
  { path: '/dashboard', label: 'Dashboard', icon: LayoutDashboard },
  { path: '/sellers', label: 'All Sellers', icon: Users },
  { path: '/sellers/pending', label: 'Pending Approval', icon: Clock },
  { path: '/products', label: 'Products', icon: Package },
  { path: '/reviews', label: 'Reviews', icon: Star },
  { path: '/messages', label: 'Messages', icon: MessageSquare },
]

export function Sidebar() {
  return (
    <aside className="w-64 border-r bg-white">
      <div className="flex h-16 items-center border-b px-6">
        <h2 className="text-xl font-bold text-primary">Marketplace</h2>
      </div>
      
      <nav className="p-4">
        <ul className="space-y-1">
          {menuItems.map((item) => (
            <li key={item.path}>
              <NavLink
                to={item.path}
                className={({ isActive }) =>
                  `flex items-center gap-3 rounded-lg px-3 py-2 transition-colors ${
                    isActive
                      ? 'bg-primary text-white'
                      : 'text-gray-700 hover:bg-gray-100'
                  }`
                }
              >
                <item.icon className="h-5 w-5" />
                <span>{item.label}</span>
              </NavLink>
            </li>
          ))}
        </ul>
      </nav>
    </aside>
  )
}

