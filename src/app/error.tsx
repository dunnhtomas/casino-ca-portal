'use client'

export default function ErrorPage({
  error,
  reset,
}: {
  error: Error & { digest?: string }
  reset: () => void
}) {
  return (
    <div className="min-h-screen flex items-center justify-center bg-gradient-to-br from-red-900 via-purple-900 to-indigo-900 px-4">
      <div className="text-center max-w-md">
        <div className="mb-8">
          <div className="text-6xl mb-4">🎲</div>
          <h1 className="text-4xl font-bold text-white mb-4">Oops!</h1>
          <h2 className="text-xl text-gray-300 mb-6">
            Something went wrong while loading Casino Masters
          </h2>
        </div>
        
        <div className="space-y-4">
          <button
            onClick={reset}
            className="w-full bg-gold-500 hover:bg-gold-600 text-black font-bold py-3 px-6 rounded-lg transition-colors"
          >
            Try Again
          </button>
          
          <a
            href="/"
            className="block w-full bg-transparent border-2 border-gold-500 text-gold-500 hover:bg-gold-500 hover:text-black font-bold py-3 px-6 rounded-lg transition-colors"
          >
            Go Home
          </a>
        </div>
        
        {error.digest && (
          <div className="mt-6 text-xs text-gray-500">
            Error ID: {error.digest}
          </div>
        )}
      </div>
    </div>
  )
}
