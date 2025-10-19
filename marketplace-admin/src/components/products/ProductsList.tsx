import { useQuery } from '@tantml/react-query'
import { magentoApi } from '../../services/magentoApiService'

export function ProductsList() {
  const { data: products, isLoading } = useQuery({
    queryKey: ['products'],
    queryFn: () => magentoApi.getProducts(),
  })

  if (isLoading) {
    return <div>Loading...</div>
  }

  return (
    <div className="space-y-4">
      <h2 className="text-3xl font-bold">Products</h2>
      
      <div className="rounded-lg border bg-white">
        <table className="w-full">
          <thead className="border-b bg-gray-50">
            <tr>
              <th className="px-6 py-3 text-left text-sm font-medium">SKU</th>
              <th className="px-6 py-3 text-left text-sm font-medium">Name</th>
              <th className="px-6 py-3 text-left text-sm font-medium">Price</th>
              <th className="px-6 py-3 text-left text-sm font-medium">Stock</th>
              <th className="px-6 py-3 text-left text-sm font-medium">Status</th>
            </tr>
          </thead>
          <tbody className="divide-y">
            {products?.map((product) => (
              <tr key={product.id}>
                <td className="px-6 py-4 text-sm">{product.sku}</td>
                <td className="px-6 py-4 text-sm font-medium">{product.name}</td>
                <td className="px-6 py-4 text-sm">${product.price}</td>
                <td className="px-6 py-4 text-sm">{product.stock}</td>
                <td className="px-6 py-4 text-sm">{product.status}</td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>
    </div>
  )
}

