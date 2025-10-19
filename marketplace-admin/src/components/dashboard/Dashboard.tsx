import { useQuery } from '@tanstack/react-query'
import { magentoApi } from '../../services/magentoApiService'
import { StatsCard } from './StatsCard'
import { SellerChart } from './SellerChart'
import { Users, Package, Star, MessageSquare, TrendingUp, Clock } from 'lucide-react'

export function Dashboard() {
  const { data: stats, isLoading } = useQuery({
    queryKey: ['marketplace-stats'],
    queryFn: () => magentoApi.getStats(),
  })

  if (isLoading) {
    return <div className="flex items-center justify-center h-full">Loading...</div>
  }

  return (
    <div className="space-y-6">
      <div>
        <h2 className="text-3xl font-bold tracking-tight">Dashboard</h2>
        <p className="text-muted-foreground">
          Marketplace overview and statistics
        </p>
      </div>

      {/* Stats Grid */}
      <div className="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
        <StatsCard
          title="Total Sellers"
          value={stats?.total_sellers || 0}
          icon={Users}
          trend={+12}
        />
        <StatsCard
          title="Pending Approval"
          value={stats?.pending_sellers || 0}
          icon={Clock}
          variant="warning"
        />
        <StatsCard
          title="Total Products"
          value={stats?.total_products || 0}
          icon={Package}
          trend={+8}
        />
        <StatsCard
          title="Avg Rating"
          value={stats?.average_rating.toFixed(1) || '0.0'}
          icon={Star}
          variant="success"
        />
      </div>

      {/* Charts */}
      <div className="grid gap-4 md:grid-cols-2">
        <div className="rounded-lg border bg-white p-6">
          <h3 className="mb-4 text-lg font-semibold">Seller Growth</h3>
          <SellerChart />
        </div>

        <div className="rounded-lg border bg-white p-6">
          <h3 className="mb-4 text-lg font-semibold">Recent Activity</h3>
          <div className="space-y-3">
            <div className="flex items-center gap-3 border-l-4 border-blue-500 pl-3">
              <div className="flex-1">
                <p className="font-medium">New seller registered</p>
                <p className="text-sm text-gray-500">2 hours ago</p>
              </div>
            </div>
            <div className="flex items-center gap-3 border-l-4 border-green-500 pl-3">
              <div className="flex-1">
                <p className="font-medium">Seller approved</p>
                <p className="text-sm text-gray-500">5 hours ago</p>
              </div>
            </div>
            <div className="flex items-center gap-3 border-l-4 border-purple-500 pl-3">
              <div className="flex-1">
                <p className="font-medium">New product added</p>
                <p className="text-sm text-gray-500">1 day ago</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  )
}

