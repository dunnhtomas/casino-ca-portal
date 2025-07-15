'use client'

export function RegionalSection() {
  const provinces = [
    { name: 'Ontario', players: '14.8M', legalStatus: 'Regulated', url: '/ontario-casinos' },
    { name: 'Quebec', players: '8.5M', legalStatus: 'Provincial', url: '/quebec-casinos' },
    { name: 'British Columbia', players: '5.1M', legalStatus: 'Provincial', url: '/bc-casinos' },
    { name: 'Alberta', players: '4.4M', legalStatus: 'Provincial', url: '/alberta-casinos' },
    { name: 'Manitoba', players: '1.4M', legalStatus: 'Provincial', url: '/manitoba-casinos' },
    { name: 'Saskatchewan', players: '1.2M', legalStatus: 'Provincial', url: '/saskatchewan-casinos' }
  ]

  return (
    <section className="py-20 bg-white">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {/* Section Header */}
        <div className="text-center mb-16">
          <h2 className="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
            Province-Specific Casino Information
          </h2>
          <p className="text-xl text-gray-600 max-w-3xl mx-auto">
            Find casinos that accept players from your province. Each region has different 
            regulations and available options for online gambling.
          </p>
        </div>

        {/* Provinces Grid */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          {provinces.map((province, index) => (
            <a
              key={index}
              href={province.url}
              className="bg-gradient-to-br from-red-50 to-red-100 rounded-2xl p-6 hover:shadow-lg transition-all transform hover:scale-105"
            >
              <div className="flex items-center justify-between mb-4">
                <h3 className="text-xl font-bold text-gray-900">{province.name}</h3>
                <span className="text-2xl">🍁</span>
              </div>
              <div className="space-y-2 text-sm text-gray-600">
                <div className="flex justify-between">
                  <span>Players:</span>
                  <span className="font-semibold">{province.players}</span>
                </div>
                <div className="flex justify-between">
                  <span>Status:</span>
                  <span className="font-semibold text-green-600">{province.legalStatus}</span>
                </div>
              </div>
              <div className="mt-4 text-blue-600 font-semibold text-sm">
                View {province.name} Casinos →
              </div>
            </a>
          ))}
        </div>
      </div>
    </section>
  )
}
