import type { Metadata, Viewport } from 'next'
import { Inter } from 'next/font/google'
import { Analytics } from '@vercel/analytics/react'
import { SpeedInsights } from '@vercel/speed-insights/next'
import './globals.css'

const inter = Inter({ 
  subsets: ['latin'],
  display: 'swap',
  variable: '--font-inter',
})

export const viewport: Viewport = {
  width: 'device-width',
  initialScale: 1,
  maximumScale: 5,
  userScalable: true,
  themeColor: [
    { media: '(prefers-color-scheme: light)', color: '#ffffff' },
    { media: '(prefers-color-scheme: dark)', color: '#000000' },
  ],
}

export const metadata: Metadata = {
  title: {
    default: 'Casino Masters Canada - Best Online Casinos 2025 | Expert Reviews & Bonuses',
    template: '%s | Casino Masters Canada'
  },
  description: 'Discover Canada\'s top-rated online casinos with expert reviews, exclusive bonuses, and comprehensive guides. Find the best casino games, payment methods, and trusted operators for Canadian players.',
  keywords: [
    'online casinos canada',
    'best casino sites',
    'casino bonuses',
    'casino reviews',
    'gambling canada',
    'slots online',
    'casino games',
    'canadian casino',
  ],
  authors: [{ name: 'Casino Masters Team' }],
  creator: 'Casino Masters',
  publisher: 'Casino Masters Canada',
  alternates: {
    canonical: 'https://casinomasters.ca',
    languages: {
      'en-CA': 'https://casinomasters.ca',
      'fr-CA': 'https://casinomasters.ca/fr',
    },
  },
  openGraph: {
    type: 'website',
    locale: 'en_CA',
    url: 'https://casinomasters.ca',
    siteName: 'Casino Masters Canada',
    title: 'Casino Masters Canada - Best Online Casinos 2025',
    description: 'Expert reviews of Canada\'s top online casinos, exclusive bonuses, and comprehensive gambling guides for Canadian players.',
    images: [
      {
        url: 'https://casinomasters.ca/images/og-image.jpg',
        width: 1200,
        height: 630,
        alt: 'Casino Masters Canada - Best Online Casinos',
      },
    ],
  },
  twitter: {
    card: 'summary_large_image',
    title: 'Casino Masters Canada - Best Online Casinos 2025',
    description: 'Expert reviews of Canada\'s top online casinos, exclusive bonuses, and comprehensive gambling guides.',
    images: ['https://casinomasters.ca/images/twitter-card.jpg'],
    creator: '@CasinoMastersCA',
  },
  robots: {
    index: true,
    follow: true,
    nocache: false,
    googleBot: {
      index: true,
      follow: true,
      noimageindex: false,
      'max-video-preview': -1,
      'max-image-preview': 'large',
      'max-snippet': -1,
    },
  },
  verification: {
    google: 'your-google-verification-code',
    yandex: 'your-yandex-verification-code',
    yahoo: 'your-yahoo-verification-code',
  },
  category: 'gambling',
  classification: 'Adult',
  referrer: 'origin-when-cross-origin',
  formatDetection: {
    email: false,
    address: false,
    telephone: false,
  },
}

export default function RootLayout({
  children,
}: {
  children: React.ReactNode
}) {
  return (
    <html lang="en-CA" className={inter.variable}>
      <head>
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossOrigin="anonymous" />
        <link rel="dns-prefetch" href="https://analytics.google.com" />
        <link rel="dns-prefetch" href="https://www.google-analytics.com" />
        
        {/* Structured Data */}
        <script
          type="application/ld+json"
          dangerouslySetInnerHTML={{
            __html: JSON.stringify({
              "@context": "https://schema.org",
              "@type": "Organization",
              "name": "Casino Masters Canada",
              "url": "https://casinomasters.ca",
              "logo": "https://casinomasters.ca/images/logo.png",
              "description": "Expert reviews of Canada's top online casinos and gambling guides",
              "sameAs": [
                "https://twitter.com/CasinoMastersCA",
                "https://facebook.com/CasinoMastersCA"
              ],
              "contactPoint": {
                "@type": "ContactPoint",
                "telephone": "+1-800-CASINO",
                "contactType": "customer service",
                "availableLanguage": ["English", "French"]
              }
            })
          }}
        />
      </head>
      <body className="font-inter antialiased bg-white text-gray-900">
        <div id="root">
          {children}
        </div>
        <Analytics />
        <SpeedInsights />
      </body>
    </html>
  )
}
