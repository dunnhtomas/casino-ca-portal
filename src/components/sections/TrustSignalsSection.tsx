'use client'

export function TrustSignalsSection() {
  const trustMetrics = [
    {
      icon: '🛡️',
      title: 'SSL Encryption',
      description: 'All recommended casinos use 256-bit SSL encryption to protect your data.',
      stat: '100%'
    },
    {
      icon: '📜',
      title: 'Licensed & Regulated',
      description: 'Only casinos with valid licenses from respected gaming authorities.',
      stat: '100%'
    },
    {
      icon: '🔍',
      title: 'Independently Audited',
      description: 'Regular audits by third-party companies ensure fair gaming.',
      stat: '100%'
    },
    {
      icon: '💰',
      title: 'Fast Payouts',
      description: 'Average withdrawal time under 24 hours for most payment methods.',
      stat: '<24hrs'
    }
  ]

  const certifications = [
    'Malta Gaming Authority (MGA)',
    'UK Gambling Commission (UKGC)',
    'Kahnawake Gaming Commission',
    'Curacao eGaming',
    'eCOGRA Certified',
    'iTech Labs Tested'
  ]

  return (
    <section className="py-20 bg-white">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {/* Section Header */}
        <div className="text-center mb-16">
          <h2 className="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
            Your Safety is Our Priority
          </h2>
          <p className="text-xl text-gray-600 max-w-3xl mx-auto">
            We only recommend casinos that meet our strict safety and security standards. 
            Every casino is thoroughly vetted before appearing on our site.
          </p>
        </div>

        {/* Trust Metrics Grid */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-16">
          {trustMetrics.map((metric, index) => (
            <div key={index} className="text-center">
              <div className="text-5xl mb-4">{metric.icon}</div>
              <div className="text-3xl font-bold text-green-600 mb-2">{metric.stat}</div>
              <h3 className="text-xl font-semibold text-gray-900 mb-3">{metric.title}</h3>
              <p className="text-gray-600 text-sm leading-relaxed">{metric.description}</p>
            </div>
          ))}
        </div>

        {/* Certifications */}
        <div className="bg-gray-50 rounded-2xl p-8">
          <h3 className="text-2xl font-bold text-gray-900 text-center mb-8">
            Trusted Licensing & Certifications
          </h3>
          <div className="grid grid-cols-2 md:grid-cols-3 gap-4 text-center">
            {certifications.map((cert, index) => (
              <div key={index} className="bg-white rounded-lg p-4 shadow-sm">
                <div className="text-sm font-semibold text-gray-800">{cert}</div>
              </div>
            ))}
          </div>
        </div>
      </div>
    </section>
  )
}
