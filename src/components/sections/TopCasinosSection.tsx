'use client'

import { cn } from '@/lib/utils'

interface Casino {
  id: string
  name: string
  logo: string
  rating: number
  bonus: string
  features: string[]
  pros: string[]
  cons: string[]
  playUrl: string
  reviewUrl: string
  isSponsored?: boolean
}

const topCasinos: Casino[] = [
  {
    id: '1',
    name: 'Spin Casino',
    logo: '/logos/spin-casino.png',
    rating: 9.5,
    bonus: 'Up to $1,000 + 50 Free Spins',
    features: ['750+ Games', 'Live Dealer', '24/7 Support', 'Mobile App'],
    pros: ['Huge game selection', 'Fast payouts', 'Excellent mobile experience'],
    cons: ['High wagering requirements'],
    playUrl: '#',
    reviewUrl: '/casinos/spin-casino',
    isSponsored: true
  },
  {
    id: '2',
    name: 'Jackpot City',
    logo: '/logos/jackpot-city.png',
    rating: 9.3,
    bonus: 'Up to $1,600 Welcome Package',
    features: ['500+ Games', 'Microgaming', 'VIP Program', 'Live Chat'],
    pros: ['Trusted brand', 'Great loyalty program', 'Regular promotions'],
    cons: ['Limited live dealer games'],
    playUrl: '#',
    reviewUrl: '/casinos/jackpot-city'
  },
  {
    id: '3',
    name: 'Royal Vegas',
    logo: '/logos/royal-vegas.png',
    rating: 9.1,
    bonus: 'Up to $1,200 + 120 Free Spins',
    features: ['600+ Games', 'Multiple Providers', 'Crypto Accepted', 'Fast Withdrawals'],
    pros: ['Accepts cryptocurrency', 'Quick verification', 'Great customer service'],
    cons: ['Geographic restrictions'],
    playUrl: '#',
    reviewUrl: '/casinos/royal-vegas'
  }
]

export function TopCasinosSection() {
  return (
    <section className="py-20 bg-gray-50">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {/* Section Header */}
        <div className="text-center mb-16">
          <h2 className="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
            Top Rated Canadian Online Casinos
          </h2>
          <p className="text-xl text-gray-600 max-w-3xl mx-auto">
            Our experts have tested and ranked the best online casinos for Canadian players. 
            These casinos offer the safest, most rewarding gaming experiences.
          </p>
        </div>

        {/* Casino Cards */}
        <div className="space-y-8">
          {topCasinos.map((casino, index) => (
            <div
              key={casino.id}
              className={cn(
                "bg-white rounded-2xl shadow-lg border-2 p-6 md:p-8 transition-all hover:shadow-xl",
                index === 0 && "border-gold-500 relative",
                index !== 0 && "border-gray-200"
              )}
            >
              {/* Sponsored Badge */}
              {casino.isSponsored && (
                <div className="absolute -top-3 left-8 bg-gold-500 text-black text-sm font-bold px-4 py-1 rounded-full">
                  Editor&apos;s Choice
                </div>
              )}

              <div className="grid grid-cols-1 lg:grid-cols-4 gap-6 items-center">
                {/* Casino Info */}
                <div className="lg:col-span-1">
                  <div className="flex items-center space-x-4 mb-4">
                    <div className="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center">
                      <span className="text-2xl font-bold text-gray-600">
                        {casino.name.charAt(0)}
                      </span>
                    </div>
                    <div>
                      <h3 className="text-xl font-bold text-gray-900">{casino.name}</h3>
                      <div className="flex items-center space-x-1">
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
                        <span className="text-sm text-gray-600 ml-1">{casino.rating}/10</span>
                      </div>
                    </div>
                  </div>
                  <div className="text-lg font-bold text-green-600 mb-2">{casino.bonus}</div>
                </div>

                {/* Features */}
                <div className="lg:col-span-1">
                  <h4 className="font-semibold text-gray-900 mb-2">Key Features</h4>
                  <ul className="space-y-1 text-sm text-gray-600">
                    {casino.features.map((feature, idx) => (
                      <li key={idx} className="flex items-center">
                        <span className="w-1.5 h-1.5 bg-green-500 rounded-full mr-2"></span>
                        {feature}
                      </li>
                    ))}
                  </ul>
                </div>

                {/* Pros & Cons */}
                <div className="lg:col-span-1">
                  <div className="grid grid-cols-1 gap-4">
                    <div>
                      <h4 className="font-semibold text-green-600 mb-2 text-sm">Pros</h4>
                      <ul className="space-y-1 text-xs text-gray-600">
                        {casino.pros.map((pro, idx) => (
                          <li key={idx} className="flex items-start">
                            <span className="text-green-500 mr-1">+</span>
                            {pro}
                          </li>
                        ))}
                      </ul>
                    </div>
                    <div>
                      <h4 className="font-semibold text-red-600 mb-2 text-sm">Cons</h4>
                      <ul className="space-y-1 text-xs text-gray-600">
                        {casino.cons.map((con, idx) => (
                          <li key={idx} className="flex items-start">
                            <span className="text-red-500 mr-1">-</span>
                            {con}
                          </li>
                        ))}
                      </ul>
                    </div>
                  </div>
                </div>

                {/* CTA Buttons */}
                <div className="lg:col-span-1 flex flex-col space-y-3">
                  <a
                    href={casino.playUrl}
                    className="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg text-center transition-colors"
                    target="_blank"
                    rel="noopener noreferrer"
                  >
                    Play Now
                  </a>
                  <a
                    href={casino.reviewUrl}
                    className="bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold py-3 px-6 rounded-lg text-center transition-colors"
                  >
                    Read Review
                  </a>
                  <div className="text-xs text-gray-500 text-center">
                    T&C Apply • 18+
                  </div>
                </div>
              </div>
            </div>
          ))}
        </div>

        {/* View All Button */}
        <div className="text-center mt-12">
          <a
            href="/casinos"
            className="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-8 rounded-xl transition-colors"
          >
            View All Canadian Casinos
            <svg className="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17 8l4 4m0 0l-4 4m4-4H3" />
            </svg>
          </a>
        </div>
      </div>
    </section>
  )
}
