'use client'

import { cn } from '@/lib/utils'

interface Bonus {
  id: string
  title: string
  amount: string
  type: 'welcome' | 'no-deposit' | 'free-spins' | 'reload'
  casino: string
  wager: string
  validDays: number
  code?: string
  features: string[]
  claimUrl: string
  isExclusive?: boolean
}

const featuredBonuses: Bonus[] = [
  {
    id: '1',
    title: 'Massive Welcome Package',
    amount: 'Up to $1,500 + 200 Free Spins',
    type: 'welcome',
    casino: 'Spin Casino',
    wager: '35x',
    validDays: 7,
    code: 'SPIN200',
    features: ['4 Deposit Match', 'Weekly Bonuses', 'VIP Program'],
    claimUrl: '#',
    isExclusive: true
  },
  {
    id: '2',
    title: 'No Deposit Bonus',
    amount: '$25 Free + 50 Spins',
    type: 'no-deposit',
    casino: 'JackpotCity',
    wager: '50x',
    validDays: 3,
    features: ['No Deposit Required', 'Instant Credit', 'Mobile Friendly'],
    claimUrl: '#',
    isExclusive: true
  },
  {
    id: '3',
    title: 'Mega Free Spins',
    amount: '300 Free Spins',
    type: 'free-spins',
    casino: 'Royal Vegas',
    wager: '40x',
    validDays: 10,
    features: ['Popular Slots', 'No Max Cashout', 'Daily Rewards'],
    claimUrl: '#'
  },
  {
    id: '4',
    title: 'Weekend Reload',
    amount: '100% Match up to $500',
    type: 'reload',
    casino: 'Casino Cruise',
    wager: '30x',
    validDays: 7,
    code: 'WEEKEND100',
    features: ['Every Weekend', 'All Games', 'Fast Processing'],
    claimUrl: '#'
  }
]

const getBonusTypeColor = (type: Bonus['type']) => {
  switch (type) {
    case 'welcome':
      return 'bg-blue-100 text-blue-800'
    case 'no-deposit':
      return 'bg-green-100 text-green-800'
    case 'free-spins':
      return 'bg-purple-100 text-purple-800'
    case 'reload':
      return 'bg-orange-100 text-orange-800'
    default:
      return 'bg-gray-100 text-gray-800'
  }
}

const getBonusTypeLabel = (type: Bonus['type']) => {
  switch (type) {
    case 'welcome':
      return 'Welcome Bonus'
    case 'no-deposit':
      return 'No Deposit'
    case 'free-spins':
      return 'Free Spins'
    case 'reload':
      return 'Reload Bonus'
    default:
      return 'Bonus'
  }
}

export function FeaturedBonusesSection() {
  return (
    <section className="py-20 bg-gradient-to-br from-indigo-900 via-purple-900 to-blue-900">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {/* Section Header */}
        <div className="text-center mb-16">
          <h2 className="text-4xl md:text-5xl font-bold text-white mb-6">
            Exclusive Casino Bonuses
          </h2>
          <p className="text-xl text-gray-300 max-w-3xl mx-auto">
            Claim the best casino bonuses available to Canadian players. Our exclusive deals 
            give you more value and better chances to win.
          </p>
        </div>

        {/* Bonus Cards Grid */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
          {featuredBonuses.map((bonus) => (
            <div
              key={bonus.id}
              className="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all transform hover:scale-105 relative overflow-hidden"
            >
              {/* Exclusive Badge */}
              {bonus.isExclusive && (
                <div className="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full transform rotate-12">
                  EXCLUSIVE
                </div>
              )}

              {/* Bonus Type */}
              <div className="mb-4">
                <span className={cn(
                  "inline-block px-3 py-1 rounded-full text-xs font-semibold",
                  getBonusTypeColor(bonus.type)
                )}>
                  {getBonusTypeLabel(bonus.type)}
                </span>
              </div>

              {/* Bonus Amount */}
              <div className="mb-4">
                <h3 className="text-xl font-bold text-gray-900 mb-2">{bonus.title}</h3>
                <div className="text-2xl font-bold text-green-600">{bonus.amount}</div>
              </div>

              {/* Casino Name */}
              <div className="text-sm text-gray-600 mb-4">
                Available at <span className="font-semibold">{bonus.casino}</span>
              </div>

              {/* Bonus Details */}
              <div className="space-y-2 mb-6 text-sm text-gray-600">
                <div className="flex justify-between">
                  <span>Wagering:</span>
                  <span className="font-semibold">{bonus.wager}</span>
                </div>
                <div className="flex justify-between">
                  <span>Valid for:</span>
                  <span className="font-semibold">{bonus.validDays} days</span>
                </div>
                {bonus.code && (
                  <div className="flex justify-between">
                    <span>Code:</span>
                    <span className="font-semibold text-blue-600">{bonus.code}</span>
                  </div>
                )}
              </div>

              {/* Features */}
              <div className="mb-6">
                <ul className="space-y-1 text-xs text-gray-600">
                  {bonus.features.map((feature, idx) => (
                    <li key={idx} className="flex items-center">
                      <span className="w-1.5 h-1.5 bg-green-500 rounded-full mr-2"></span>
                      {feature}
                    </li>
                  ))}
                </ul>
              </div>

              {/* CTA Button */}
              <a
                href={bonus.claimUrl}
                className="block w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-3 px-4 rounded-lg text-center transition-all"
                target="_blank"
                rel="noopener noreferrer"
              >
                Claim Bonus
              </a>

              {/* Terms */}
              <div className="text-xs text-gray-500 text-center mt-2">
                T&C Apply • 18+ • BeGambleAware
              </div>
            </div>
          ))}
        </div>

        {/* Bonus Tips */}
        <div className="bg-white/10 backdrop-blur-sm rounded-2xl p-8 mb-12">
          <h3 className="text-2xl font-bold text-white mb-6 text-center">
            💡 Bonus Tips for Canadian Players
          </h3>
          <div className="grid grid-cols-1 md:grid-cols-3 gap-6 text-white">
            <div className="text-center">
              <div className="text-3xl mb-3">📖</div>
              <h4 className="font-semibold mb-2">Read Terms Carefully</h4>
              <p className="text-sm text-gray-300">
                Always check wagering requirements, game restrictions, and maximum withdrawal limits.
              </p>
            </div>
            <div className="text-center">
              <div className="text-3xl mb-3">🎯</div>
              <h4 className="font-semibold mb-2">Choose Wisely</h4>
              <p className="text-sm text-gray-300">
                Lower wagering requirements often provide better value than larger bonus amounts.
              </p>
            </div>
            <div className="text-center">
              <div className="text-3xl mb-3">⏰</div>
              <h4 className="font-semibold mb-2">Use Time Limits</h4>
              <p className="text-sm text-gray-300">
                Most bonuses have expiry dates. Plan your gameplay to meet requirements in time.
              </p>
            </div>
          </div>
        </div>

        {/* View All Bonuses Button */}
        <div className="text-center">
          <a
            href="/bonuses"
            className="inline-flex items-center bg-gold-500 hover:bg-gold-600 text-black font-bold py-4 px-8 rounded-xl transition-colors"
          >
            View All Casino Bonuses
            <svg className="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17 8l4 4m0 0l-4 4m4-4H3" />
            </svg>
          </a>
        </div>
      </div>
    </section>
  )
}
