import { useQuery } from '@tanstack/react-query'
import { magentoApi } from '../../services/magentoApiService'
import { format } from 'date-fns'
import { MoreHorizontal, CheckCircle, XCircle, Pause } from 'lucide-react'

export function SellersList() {
  const { data: sellers, isLoading } = useQuery({
    queryKey: ['sellers'],
    queryFn: () => magentoApi.getAllSellers(),
  })

  if (isLoading) {
    return <div>Loading...</div>
  }

  return (
    <div className="space-y-4">
      <div className="flex items-center justify-between">
        <div>
          <h2 className="text-3xl font-bold tracking-tight">All Sellers</h2>
          <p className="text-muted-foreground">
            Manage marketplace sellers
          </p>
        </div>
      </div>

      <div className="rounded-lg border bg-white">
        <table className="w-full">
          <thead className="border-b bg-gray-50">
            <tr>
              <th className="px-6 py-3 text-left text-sm font-medium text-gray-900">
                ID
              </th>
              <th className="px-6 py-3 text-left text-sm font-medium text-gray-900">
                Name
              </th>
              <th className="px-6 py-3 text-left text-sm font-medium text-gray-900">
                Email
              </th>
              <th className="px-6 py-3 text-left text-sm font-medium text-gray-900">
                Status
              </th>
              <th className="px-6 py-3 text-left text-sm font-medium text-gray-900">
                Rating
              </th>
              <th className="px-6 py-3 text-left text-sm font-medium text-gray-900">
                Sales
              </th>
              <th className="px-6 py-3 text-left text-sm font-medium text-gray-900">
                Created
              </th>
              <th className="px-6 py-3 text-right text-sm font-medium text-gray-900">
                Actions
              </th>
            </tr>
          </thead>
          <tbody className="divide-y">
            {sellers?.map((seller) => (
              <tr key={seller.id} className="hover:bg-gray-50">
                <td className="px-6 py-4 text-sm">{seller.id}</td>
                <td className="px-6 py-4 text-sm font-medium">{seller.name}</td>
                <td className="px-6 py-4 text-sm text-gray-500">{seller.email}</td>
                <td className="px-6 py-4">
                  <StatusBadge status={seller.status} />
                </td>
                <td className="px-6 py-4 text-sm">
                  ⭐ {seller.rating.toFixed(1)}
                </td>
                <td className="px-6 py-4 text-sm">${seller.total_sales}</td>
                <td className="px-6 py-4 text-sm text-gray-500">
                  {format(new Date(seller.created_at), 'MMM dd, yyyy')}
                </td>
                <td className="px-6 py-4 text-right">
                  <button className="rounded p-1 hover:bg-gray-100">
                    <MoreHorizontal className="h-5 w-5" />
                  </button>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>
    </div>
  )
}

function StatusBadge({ status }: { status: string }) {
  const styles = {
    pending: 'bg-yellow-100 text-yellow-800',
    approved: 'bg-green-100 text-green-800',
    rejected: 'bg-red-100 text-red-800',
    suspended: 'bg-gray-100 text-gray-800',
  }

  const icons = {
    pending: Clock,
    approved: CheckCircle,
    rejected: XCircle,
    suspended: Pause,
  }

  const Icon = icons[status as keyof typeof icons] || Clock

  return (
    <span
      className={`inline-flex items-center gap-1 rounded-full px-2 py-1 text-xs font-semibold ${
        styles[status as keyof typeof styles]
      }`}
    >
      <Icon className="h-3 w-3" />
      {status.charAt(0).toUpperCase() + status.slice(1)}
    </span>
  )
}

