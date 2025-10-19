import { useState } from 'react'
import { useQuery, useMutation, useQueryClient } from '@tanstack/react-query'
import { magentoApi } from '../../services/magentoApiService'
import { format } from 'date-fns'
import { Check, X, Eye } from 'lucide-react'

export function ApprovalQueue() {
  const queryClient = useQueryClient()
  const [selectedSellers, setSelectedSellers] = useState<number[]>([])

  const { data: response, isLoading } = useQuery({
    queryKey: ['pending-sellers'],
    queryFn: () => magentoApi.getPendingSellers(),
  })

  const approveMutation = useMutation({
    mutationFn: (sellerId: number) => magentoApi.approveSeller(sellerId),
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['pending-sellers'] })
      queryClient.invalidateQueries({ queryKey: ['marketplace-stats'] })
    },
  })

  const rejectMutation = useMutation({
    mutationFn: ({ sellerId, reason }: { sellerId: number; reason: string }) =>
      magentoApi.rejectSeller(sellerId, reason),
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['pending-sellers'] })
      queryClient.invalidateQueries({ queryKey: ['marketplace-stats'] })
    },
  })

  const bulkApproveMutation = useMutation({
    mutationFn: (sellerIds: number[]) =>
      magentoApi.bulkApproveSellers(sellerIds),
    onSuccess: () => {
      setSelectedSellers([])
      queryClient.invalidateQueries({ queryKey: ['pending-sellers'] })
      queryClient.invalidateQueries({ queryKey: ['marketplace-stats'] })
    },
  })

  const handleApprove = (sellerId: number) => {
    if (confirm('Approve this seller?')) {
      approveMutation.mutate(sellerId)
    }
  }

  const handleReject = (sellerId: number) => {
    const reason = prompt('Rejection reason:')
    if (reason) {
      rejectMutation.mutate({ sellerId, reason })
    }
  }

  const handleBulkApprove = () => {
    if (confirm(`Approve ${selectedSellers.length} sellers?`)) {
      bulkApproveMutation.mutate(selectedSellers)
    }
  }

  const toggleSelection = (sellerId: number) => {
    setSelectedSellers((prev) =>
      prev.includes(sellerId)
        ? prev.filter((id) => id !== sellerId)
        : [...prev, sellerId]
    )
  }

  if (isLoading) {
    return <div>Loading...</div>
  }

  const sellers = response?.items || []

  return (
    <div className="space-y-4">
      <div className="flex items-center justify-between">
        <div>
          <h2 className="text-3xl font-bold tracking-tight">Approval Queue</h2>
          <p className="text-muted-foreground">
            {sellers.length} sellers pending approval
          </p>
        </div>

        {selectedSellers.length > 0 && (
          <button
            onClick={handleBulkApprove}
            className="rounded-lg bg-green-600 px-4 py-2 text-white hover:bg-green-700"
          >
            Approve Selected ({selectedSellers.length})
          </button>
        )}
      </div>

      <div className="rounded-lg border bg-white">
        <table className="w-full">
          <thead className="border-b bg-gray-50">
            <tr>
              <th className="w-12 px-6 py-3">
                <input
                  type="checkbox"
                  onChange={(e) =>
                    setSelectedSellers(
                      e.target.checked ? sellers.map((s) => s.id) : []
                    )
                  }
                  checked={selectedSellers.length === sellers.length}
                />
              </th>
              <th className="px-6 py-3 text-left text-sm font-medium">Name</th>
              <th className="px-6 py-3 text-left text-sm font-medium">Email</th>
              <th className="px-6 py-3 text-left text-sm font-medium">Company</th>
              <th className="px-6 py-3 text-left text-sm font-medium">Registered</th>
              <th className="px-6 py-3 text-right text-sm font-medium">Actions</th>
            </tr>
          </thead>
          <tbody className="divide-y">
            {sellers.map((seller) => (
              <tr key={seller.id} className="hover:bg-gray-50">
                <td className="px-6 py-4">
                  <input
                    type="checkbox"
                    checked={selectedSellers.includes(seller.id)}
                    onChange={() => toggleSelection(seller.id)}
                  />
                </td>
                <td className="px-6 py-4 text-sm font-medium">{seller.name}</td>
                <td className="px-6 py-4 text-sm text-gray-500">{seller.email}</td>
                <td className="px-6 py-4 text-sm">{seller.company_name || '-'}</td>
                <td className="px-6 py-4 text-sm text-gray-500">
                  {format(new Date(seller.created_at), 'MMM dd, yyyy')}
                </td>
                <td className="px-6 py-4 text-right">
                  <div className="flex justify-end gap-2">
                    <button
                      onClick={() => handleApprove(seller.id)}
                      className="rounded p-2 text-green-600 hover:bg-green-50"
                      title="Approve"
                    >
                      <Check className="h-4 w-4" />
                    </button>
                    <button
                      onClick={() => handleReject(seller.id)}
                      className="rounded p-2 text-red-600 hover:bg-red-50"
                      title="Reject"
                    >
                      <X className="h-4 w-4" />
                    </button>
                    <button
                      className="rounded p-2 text-gray-600 hover:bg-gray-50"
                      title="View Details"
                    >
                      <Eye className="h-4 w-4" />
                    </button>
                  </div>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>
    </div>
  )
}

