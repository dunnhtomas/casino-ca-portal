'use client'

export function GameGuidesSection() {
  const gameGuides = [
    {
      title: 'Blackjack Strategy Guide',
      description: 'Master basic strategy and card counting techniques',
      image: '/images/blackjack-guide.jpg',
      category: 'Table Games',
      readTime: '10 min',
      url: '/guides/blackjack-strategy'
    },
    {
      title: 'Slots RTP Explained',
      description: 'Understanding Return to Player percentages',
      image: '/images/slots-rtp.jpg',
      category: 'Slots',
      readTime: '8 min',
      url: '/guides/slots-rtp'
    },
    {
      title: 'Poker Hand Rankings',
      description: 'Complete guide to poker hands and odds',
      image: '/images/poker-hands.jpg',
      category: 'Poker',
      readTime: '15 min',
      url: '/guides/poker-hands'
    },
    {
      title: 'Roulette Betting Systems',
      description: 'Popular betting strategies and their effectiveness',
      image: '/images/roulette-systems.jpg',
      category: 'Table Games',
      readTime: '12 min',
      url: '/guides/roulette-betting'
    }
  ]

  return (
    <section className="py-20 bg-gray-50">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {/* Section Header */}
        <div className="text-center mb-16">
          <h2 className="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
            Master Your Favorite Games
          </h2>
          <p className="text-xl text-gray-600 max-w-3xl mx-auto">
            Improve your skills with our comprehensive game guides. Learn strategies, 
            understand odds, and maximize your winning potential.
          </p>
        </div>

        {/* Guides Grid */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
          {gameGuides.map((guide, index) => (
            <div key={index} className="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
              <div className="h-48 bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                <div className="text-6xl">🎮</div>
              </div>
              <div className="p-6">
                <div className="flex items-center justify-between mb-3">
                  <span className="text-xs font-semibold text-blue-600 bg-blue-100 px-2 py-1 rounded-full">
                    {guide.category}
                  </span>
                  <span className="text-xs text-gray-500">{guide.readTime}</span>
                </div>
                <h3 className="text-lg font-bold text-gray-900 mb-2">{guide.title}</h3>
                <p className="text-gray-600 text-sm mb-4">{guide.description}</p>
                <a
                  href={guide.url}
                  className="text-blue-600 hover:text-blue-800 font-semibold text-sm"
                >
                  Read Guide →
                </a>
              </div>
            </div>
          ))}
        </div>

        {/* View All Button */}
        <div className="text-center mt-12">
          <a
            href="/guides"
            className="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-8 rounded-xl transition-colors"
          >
            View All Guides
            <svg className="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17 8l4 4m0 0l-4 4m4-4H3" />
            </svg>
          </a>
        </div>
      </div>
    </section>
  )
}
