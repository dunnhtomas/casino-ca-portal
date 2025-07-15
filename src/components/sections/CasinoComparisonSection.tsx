'use client'

import { cn } from '@/lib/utils'

interface ComparisonCasino {
  name: string
  logo: string
  rating: number
  bonus: string
  games: number
  payoutTime: string
  minDeposit: string
  licenseShort: string
  trustScore: number
  playUrl: string
  reviewUrl: string
}

const comparisonCasinos: ComparisonCasino[] = [
  {
    name: 'Spin Casino',
    logo: '/logos/spin-casino.png',
    rating: 9.5,
    bonus: '$1,000 + 50 FS',
    games: 750,
    payoutTime: '1-3 days',
    minDeposit: '$10',
    licenseShort: 'MGA',
    trustScore: 98,
    playUrl: '#',
    reviewUrl: '/casinos/spin-casino'
  },
  {
    name: 'JackpotCity',
    logo: '/logos/jackpot-city.png',
    rating: 9.3,
    bonus: '$1,600 Package',
    games: 500,
    payoutTime: '2-4 days',
    minDeposit: '$10',
    licenseShort: 'MGA',
    trustScore: 96,
    playUrl: '#',
    reviewUrl: '/casinos/jackpot-city'
  },
  {
    name: 'Royal Vegas',
    logo: '/logos/royal-vegas.png',
    rating: 9.1,
    bonus: '$1,200 + 120 FS',
    games: 600,
    payoutTime: '1-2 days',
    minDeposit: '$5',
    licenseShort: 'MGA',
    trustScore: 94,
    playUrl: '#',
    reviewUrl: '/casinos/royal-vegas'
  },
  {
    name: 'Casino Cruise',
    logo: '/logos/casino-cruise.png',
    rating: 8.9,
    bonus: '$1,000 + 200 FS',
    games: 400,
    payoutTime: '2-5 days',
    minDeposit: '$20',
    licenseShort: 'Curacao',
    trustScore: 92,
    playUrl: '#',
    reviewUrl: '/casinos/casino-cruise'
  },
  {
    name: 'LeoVegas',
    logo: '/logos/leovegas.png',
    rating: 8.8,
    bonus: '$1,500 + 100 FS',
    games: 800,
    payoutTime: '1-3 days',
    minDeposit: '$10',
    licenseShort: 'MGA',
    trustScore: 90,
    playUrl: '#',
    reviewUrl: '/casinos/leovegas'
  }
]

export function CasinoComparisonSection() {
  return (
    <section className="py-20 bg-gray-50">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {/* Section Header */}
        <div className="text-center mb-12">
          <h2 className="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
            Compare Top Canadian Casinos
          </h2>
          <p className="text-xl text-gray-600 max-w-3xl mx-auto">
            Side-by-side comparison of the best online casinos for Canadian players. 
            Find the perfect casino that matches your preferences.
          </p>
        </div>

        {/* Comparison Table */}
        <div className="bg-white rounded-2xl shadow-lg overflow-hidden">
          <div className="overflow-x-auto">
            <table className="w-full">
              {/* Header */}
              <thead className="bg-gradient-to-r from-blue-600 to-purple-600 text-white">
                <tr>
                  <th className="px-6 py-4 text-left font-semibold">Casino</th>
                  <th className="px-6 py-4 text-center font-semibold">Rating</th>
                  <th className="px-6 py-4 text-center font-semibold">Welcome Bonus</th>
                  <th className="px-6 py-4 text-center font-semibold">Games</th>
                  <th className="px-6 py-4 text-center font-semibold">Payout Time</th>
                  <th className="px-6 py-4 text-center font-semibold">Min Deposit</th>
                  <th className="px-6 py-4 text-center font-semibold">License</th>
                  <th className="px-6 py-4 text-center font-semibold">Trust Score</th>
                  <th className="px-6 py-4 text-center font-semibold">Action</th>
                </tr>
              </thead>
              
              {/* Body */}
              <tbody>
                {comparisonCasinos.map((casino, index) => (
                  <tr
                    key={casino.name}
                    className={cn(
                      "border-b border-gray-200 hover:bg-gray-50 transition-colors",
                      index === 0 && "bg-gold-50 border-gold-200"
                    )}
                  >
                    {/* Casino Name */}
                    <td className="px-6 py-6">
                      <div className="flex items-center space-x-4">
                        {index === 0 && (
                          <div className="absolute -ml-2 bg-gold-500 text-black text-xs font-bold px-2 py-1 rounded-r-full">
                            #1
                          </div>
                        )}
                        <div className="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                          <span className="text-lg font-bold text-gray-600">
                            {casino.name.charAt(0)}
                          </span>
                        </div>
                        <div>
                          <div className="font-semibold text-gray-900">{casino.name}</div>
                          <a
                            href={casino.reviewUrl}
                            className="text-sm text-blue-600 hover:text-blue-800"
                          >
                            Read Review
                          </a>
                        </div>
                      </div>
                    </td>

                    {/* Rating */}
                    <td className="px-6 py-6 text-center">
                      <div className="flex items-center justify-center space-x-1">
                        <span className="font-bold text-lg">{casino.rating}</span>
                        <div className="flex">
                          {[...Array(5)].map((_, i) => (
                            <svg
                              key={i}
                              className={cn(
                                "w-4 h-4",
                                i < Math.floor(casino.rating) ? "text-gold-500" : "text-gray-300"
                              )}
                              fill="currentColor"
                              viewBox="0 0 20 20"
                            >
                              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                          ))}
                        </div>
                      </div>
                    </td>

                    {/* Bonus */}
                    <td className="px-6 py-6 text-center">
                      <div className="font-semibold text-green-600">{casino.bonus}</div>
                    </td>

                    {/* Games */}
                    <td className="px-6 py-6 text-center">
                      <div className="font-semibold">{casino.games.toLocaleString()}+</div>
                    </td>

                    {/* Payout Time */}
                    <td className="px-6 py-6 text-center">
                      <div className="font-semibold">{casino.payoutTime}</div>
                    </td>

                    {/* Min Deposit */}
                    <td className="px-6 py-6 text-center">
                      <div className="font-semibold">{casino.minDeposit}</div>
                    </td>

                    {/* License */}
                    <td className="px-6 py-6 text-center">
                      <span className="inline-block bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded-full">
                        {casino.licenseShort}
                      </span>
                    </td>

                    {/* Trust Score */}
                    <td className="px-6 py-6 text-center">
                      <div className="flex items-center justify-center">
                        <div className="relative w-12 h-12">
                          <svg className="w-12 h-12 transform -rotate-90" viewBox="0 0 36 36">
                            <path
                              className="text-gray-300"
                              d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                              fill="none"
                              stroke="currentColor"
                              strokeWidth="2"
                            />
                            <path
                              className="text-green-500"
                              d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                              fill="none"
                              stroke="currentColor"
                              strokeWidth="2"
                              strokeDasharray={`${casino.trustScore}, 100`}
                            />
                          </svg>
                          <div className="absolute inset-0 flex items-center justify-center">
                            <span className="text-xs font-bold">{casino.trustScore}</span>
                          </div>
                        </div>
                      </div>
                    </td>

                    {/* Action */}
                    <td className="px-6 py-6 text-center">
                      <a
                        href={casino.playUrl}
                        className="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition-colors"
                        target="_blank"
                        rel="noopener noreferrer"
                      >
                        Play Now
                      </a>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </div>

        {/* Comparison Notes */}
        <div className="mt-8 text-center">
          <p className="text-sm text-gray-600 max-w-4xl mx-auto">
            All casinos listed are licensed and regulated. Ratings are based on our comprehensive review process 
            including security, game variety, bonuses, customer support, and player feedback. 
            <a href="/methodology" className="text-blue-600 hover:text-blue-800 font-semibold ml-1">
              Learn about our review methodology
            </a>
          </p>
        </div>
      </div>
    </section>
  )
}
