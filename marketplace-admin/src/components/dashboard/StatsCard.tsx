import { LucideIcon, TrendingUp, TrendingDown } from 'lucide-react'

interface StatsCardProps {
  title: string
  value: number | string
  icon: LucideIcon
  trend?: number
  variant?: 'default' | 'success' | 'warning' | 'danger'
}

const variantStyles = {
  default: 'bg-blue-50 text-blue-600',
  success: 'bg-green-50 text-green-600',
  warning: 'bg-yellow-50 text-yellow-600',
  danger: 'bg-red-50 text-red-600',
}

export function StatsCard({
  title,
  value,
  icon: Icon,
  trend,
  variant = 'default',
}: StatsCardProps) {
  return (
    <div className="rounded-lg border bg-white p-6">
      <div className="flex items-center justify-between">
        <div className="flex-1">
          <p className="text-sm font-medium text-gray-500">{title}</p>
          <p className="mt-2 text-3xl font-bold">{value}</p>
          {trend !== undefined && (
            <p className="mt-2 flex items-center text-sm">
              {trend > 0 ? (
                <TrendingUp className="mr-1 h-4 w-4 text-green-600" />
              ) : (
                <TrendingDown className="mr-1 h-4 w-4 text-red-600" />
              )}
              <span className={trend > 0 ? 'text-green-600' : 'text-red-600'}>
                {Math.abs(trend)}%
              </span>
              <span className="ml-1 text-gray-500">vs last month</span>
            </p>
          )}
        </div>
        <div className={`rounded-full p-3 ${variantStyles[variant]}`}>
          <Icon className="h-6 w-6" />
        </div>
      </div>
    </div>
  )
}

