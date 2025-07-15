export default function Loading() {
  return (
    <div className="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-900 via-purple-900 to-indigo-900">
      <div className="text-center">
        <div className="animate-spin rounded-full h-16 w-16 border-t-4 border-gold-400 border-solid mb-4 mx-auto"></div>
        <h2 className="text-2xl font-bold text-white mb-2">Loading Casino Masters</h2>
        <p className="text-gray-300">Finding the best casinos for you...</p>
      </div>
    </div>
  )
}
