import {
  LineChart,
  Line,
  XAxis,
  YAxis,
  CartesianGrid,
  Tooltip,
  Legend,
  ResponsiveContainer,
} from 'recharts'

const mockData = [
  { month: 'Jan', sellers: 10, products: 45 },
  { month: 'Feb', sellers: 15, products: 68 },
  { month: 'Mar', sellers: 22, products: 95 },
  { month: 'Apr', sellers: 28, products: 120 },
  { month: 'May', sellers: 35, products: 145 },
  { month: 'Jun', sellers: 42, products: 178 },
]

export function SellerChart() {
  return (
    <ResponsiveContainer width="100%" height={300}>
      <LineChart data={mockData}>
        <CartesianGrid strokeDasharray="3 3" />
        <XAxis dataKey="month" />
        <YAxis />
        <Tooltip />
        <Legend />
        <Line
          type="monotone"
          dataKey="sellers"
          stroke="#3b82f6"
          strokeWidth={2}
        />
        <Line
          type="monotone"
          dataKey="products"
          stroke="#8b5cf6"
          strokeWidth={2}
        />
      </LineChart>
    </ResponsiveContainer>
  )
}

