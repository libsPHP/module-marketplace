import { Bell, Settings, User } from 'lucide-react'

export function Header() {
  return (
    <header className="border-b bg-white px-6 py-4">
      <div className="flex items-center justify-between">
        <div>
          <h1 className="text-2xl font-bold text-gray-900">Marketplace Admin</h1>
          <p className="text-sm text-gray-500">Manage sellers and products</p>
        </div>
        
        <div className="flex items-center gap-4">
          <button className="rounded-full p-2 hover:bg-gray-100">
            <Bell className="h-5 w-5" />
          </button>
          <button className="rounded-full p-2 hover:bg-gray-100">
            <Settings className="h-5 w-5" />
          </button>
          <button className="flex items-center gap-2 rounded-full border px-3 py-2 hover:bg-gray-100">
            <User className="h-5 w-5" />
            <span>Admin</span>
          </button>
        </div>
      </div>
    </header>
  )
}

