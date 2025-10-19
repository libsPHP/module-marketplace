import { useQuery } from '@tanstack/react-query'
import { magentoApi } from '../../services/magentoApiService'

export function ReviewsList() {
  const { data: reviews, isLoading } = useQuery({
    queryKey: ['reviews'],
    queryFn: () => magentoApi.getReviews(),
  })

  if (isLoading) {
    return <div>Loading...</div>
  }

  return (
    <div className="space-y-4">
      <h2 className="text-3xl font-bold">Reviews</h2>
      
      <div className="space-y-4">
        {reviews?.map((review) => (
          <div key={review.id} className="rounded-lg border bg-white p-6">
            <div className="flex items-start justify-between">
              <div className="flex-1">
                <div className="flex items-center gap-2">
                  <span className="font-semibold">{review.title}</span>
                  <span className="text-yellow-500">
                    {'⭐'.repeat(review.rating)}
                  </span>
                </div>
                <p className="mt-2 text-gray-600">{review.comment}</p>
                <p className="mt-2 text-sm text-gray-400">
                  Customer ID: {review.customer_id}
                </p>
              </div>
              <span
                className={`rounded-full px-3 py-1 text-xs ${
                  review.status === 'approved'
                    ? 'bg-green-100 text-green-800'
                    : review.status === 'pending'
                    ? 'bg-yellow-100 text-yellow-800'
                    : 'bg-red-100 text-red-800'
                }`}
              >
                {review.status}
              </span>
            </div>
          </div>
        ))}
      </div>
    </div>
  )
}

