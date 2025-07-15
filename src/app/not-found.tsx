export default function NotFoundPage() {
  return (
    <div className="min-h-screen flex items-center justify-center bg-gradient-to-br from-purple-900 via-blue-900 to-indigo-900 px-4">
      <div className="text-center max-w-lg">
        <div className="mb-8">
          <div className="text-9xl font-bold text-gold-400 mb-4">404</div>
          <h1 className="text-4xl font-bold text-white mb-4">Page Not Found</h1>
          <p className="text-xl text-gray-300 mb-8">
            The casino page you&apos;re looking for doesn&apos;t exist or has been moved.
          </p>
        </div>
        
        <div className="space-y-4">
          <a
            href="/"
            className="inline-block bg-gold-500 hover:bg-gold-600 text-black font-bold py-3 px-8 rounded-lg transition-colors"
          >
            Back to Home
          </a>
          
          <div className="mt-8">
            <h3 className="text-lg font-semibold text-white mb-4">Popular Pages:</h3>
            <div className="grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm">
              <a href="/casinos" className="text-gold-400 hover:text-gold-300 transition-colors">
                Top Casinos
              </a>
              <a href="/bonuses" className="text-gold-400 hover:text-gold-300 transition-colors">
                Best Bonuses
              </a>
              <a href="/games" className="text-gold-400 hover:text-gold-300 transition-colors">
                Casino Games
              </a>
              <a href="/reviews" className="text-gold-400 hover:text-gold-300 transition-colors">
                Casino Reviews
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  )
}
