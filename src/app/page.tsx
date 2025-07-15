import { Metadata } from 'next'
import { HeroSection } from '@/components/sections/HeroSection'
import { TopCasinosSection } from '@/components/sections/TopCasinosSection'
import { FeaturedBonusesSection } from '@/components/sections/FeaturedBonusesSection'
import { CasinoComparisonSection } from '@/components/sections/CasinoComparisonSection'
import { TrustSignalsSection } from '@/components/sections/TrustSignalsSection'
import { GameGuidesSection } from '@/components/sections/GameGuidesSection'
import { RegionalSection } from '@/components/sections/RegionalSection'
import { NewsSection } from '@/components/sections/NewsSection'

export const metadata: Metadata = {
  title: 'Best Online Casinos Canada 2025 | Expert Reviews & Top Bonuses',
  description: 'Compare Canada\'s top-rated online casinos with our expert reviews. Find the best casino bonuses, games, and trusted operators for Canadian players in 2025.',
  keywords: [
    'best online casinos canada',
    'online casino canada',
    'casino bonuses canada',
    'top canadian casinos',
    'casino reviews 2025',
    'legal online gambling canada'
  ],
  openGraph: {
    title: 'Best Online Casinos Canada 2025 | Casino Masters',
    description: 'Expert reviews of Canada\'s top online casinos. Find the best bonuses, games, and trusted operators.',
    url: 'https://casinomasters.ca',
    siteName: 'Casino Masters Canada',
    images: [
      {
        url: 'https://casinomasters.ca/images/homepage-og.jpg',
        width: 1200,
        height: 630,
        alt: 'Best Online Casinos Canada 2025',
      },
    ],
    locale: 'en_CA',
    type: 'website',
  },
  twitter: {
    card: 'summary_large_image',
    title: 'Best Online Casinos Canada 2025 | Casino Masters',
    description: 'Expert reviews of Canada\'s top online casinos. Find the best bonuses, games, and trusted operators.',
    images: ['https://casinomasters.ca/images/homepage-twitter.jpg'],
  },
  alternates: {
    canonical: 'https://casinomasters.ca',
  },
}

// Structured data for homepage
const structuredData = {
  "@context": "https://schema.org",
  "@type": "WebSite",
  "name": "Casino Masters Canada",
  "url": "https://casinomasters.ca",
  "description": "Expert reviews of Canada's top online casinos and gambling guides",
  "potentialAction": {
    "@type": "SearchAction",
    "target": {
      "@type": "EntryPoint",
      "urlTemplate": "https://casinomasters.ca/search?q={search_term_string}"
    },
    "query-input": "required name=search_term_string"
  },
  "publisher": {
    "@type": "Organization",
    "name": "Casino Masters Canada",
    "logo": {
      "@type": "ImageObject",
      "url": "https://casinomasters.ca/images/logo.png"
    }
  }
}

export default function HomePage() {
  return (
    <div className="min-h-screen">
      {/* Structured Data */}
      <script
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(structuredData) }}
      />
      
      {/* Hero Section */}
      <HeroSection />
      
      {/* Top Casinos Section */}
      <TopCasinosSection />
      
      {/* Featured Bonuses */}
      <FeaturedBonusesSection />
      
      {/* Casino Comparison Table */}
      <CasinoComparisonSection />
      
      {/* Trust & Security Section */}
      <TrustSignalsSection />
      
      {/* Game Guides Section */}
      <GameGuidesSection />
      
      {/* Regional Information */}
      <RegionalSection />
      
      {/* Latest News & Updates */}
      <NewsSection />
    </div>
  )
}
