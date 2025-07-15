'use client'

export function NewsSection() {
  const newsArticles = [
    {
      title: 'Ontario iGaming Market Reaches Record Revenue in Q4 2024',
      excerpt: 'The regulated Ontario market continues to show strong growth with new operator launches.',
      date: '2024-12-15',
      category: 'Industry News',
      url: '/news/ontario-igaming-record-revenue'
    },
    {
      title: 'New Payment Methods Available for Canadian Players',
      excerpt: 'Several casinos now accept additional cryptocurrency options and e-wallets.',
      date: '2024-12-10',
      category: 'Player Updates',
      url: '/news/new-payment-methods'
    },
    {
      title: 'Christmas Casino Bonuses: Best Deals for December 2024',
      excerpt: 'Exclusive holiday promotions from top Canadian online casinos.',
      date: '2024-12-05',
      category: 'Promotions',
      url: '/news/christmas-casino-bonuses'
    },
    {
      title: 'Evolution Gaming Launches New Live Dealer Studio',
      excerpt: 'Enhanced live dealer experience with new games and features.',
      date: '2024-12-01',
      category: 'Game Updates',
      url: '/news/evolution-new-studio'
    }
  ]

  return (
    <section className="py-20 bg-gray-900">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {/* Section Header */}
        <div className="text-center mb-16">
          <h2 className="text-4xl md:text-5xl font-bold text-white mb-6">
            Latest Casino News & Updates
          </h2>
          <p className="text-xl text-gray-300 max-w-3xl mx-auto">
            Stay informed with the latest developments in the Canadian online casino industry. 
            News, updates, and exclusive insights from our expert team.
          </p>
        </div>

        {/* News Grid */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
          {newsArticles.map((article, index) => (
            <article
              key={index}
              className="bg-gray-800 rounded-2xl p-6 hover:bg-gray-750 transition-colors"
            >
              <div className="mb-4">
                <span className="text-xs font-semibold text-gold-400 bg-gold-400/20 px-2 py-1 rounded-full">
                  {article.category}
                </span>
              </div>
              <h3 className="text-lg font-bold text-white mb-3 line-clamp-2">
                {article.title}
              </h3>
              <p className="text-gray-300 text-sm mb-4 line-clamp-3">
                {article.excerpt}
              </p>
              <div className="flex items-center justify-between">
                <span className="text-xs text-gray-500">
                  {new Date(article.date).toLocaleDateString('en-CA', {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                  })}
                </span>
                <a
                  href={article.url}
                  className="text-gold-400 hover:text-gold-300 font-semibold text-sm"
                >
                  Read More →
                </a>
              </div>
            </article>
          ))}
        </div>

        {/* Newsletter Signup */}
        <div className="bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl p-8 text-center">
          <h3 className="text-2xl font-bold text-white mb-4">
            Stay Updated with Casino News
          </h3>
          <p className="text-blue-100 mb-6 max-w-2xl mx-auto">
            Get the latest casino news, exclusive bonuses, and expert insights delivered to your inbox weekly.
          </p>
          <form className="max-w-md mx-auto flex gap-4">
            <input
              type="email"
              placeholder="Enter your email"
              className="flex-1 px-4 py-3 rounded-lg bg-white/10 backdrop-blur-sm border border-white/20 text-white placeholder-blue-200 focus:outline-none focus:ring-2 focus:ring-white/50"
            />
            <button
              type="submit"
              className="bg-white text-blue-600 font-bold px-6 py-3 rounded-lg hover:bg-blue-50 transition-colors"
            >
              Subscribe
            </button>
          </form>
          <p className="text-xs text-blue-200 mt-3">
            No spam, unsubscribe anytime. Privacy policy applies.
          </p>
        </div>

        {/* View All News Button */}
        <div className="text-center mt-12">
          <a
            href="/news"
            className="inline-flex items-center bg-gold-500 hover:bg-gold-600 text-black font-bold py-4 px-8 rounded-xl transition-colors"
          >
            View All News
            <svg className="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17 8l4 4m0 0l-4 4m4-4H3" />
            </svg>
          </a>
        </div>
      </div>
    </section>
  )
}
