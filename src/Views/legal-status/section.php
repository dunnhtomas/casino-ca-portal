<section class="legal-status-section py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <!-- Section Header -->
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">
                    Legal Status & Regulation in Canada
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Understanding the complex legal landscape of online gambling in Canada. Each province 
                    has its own regulations and licensing requirements.
                </p>
            </div>

            <!-- Summary Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
                <div class="bg-white rounded-lg p-6 text-center shadow-sm">
                    <div class="text-3xl font-bold text-green-600 mb-2"><?= $summary['regulated'] ?></div>
                    <div class="text-sm text-gray-600">Regulated Markets</div>
                </div>
                <div class="bg-white rounded-lg p-6 text-center shadow-sm">
                    <div class="text-3xl font-bold text-yellow-600 mb-2"><?= $summary['monopoly'] ?></div>
                    <div class="text-sm text-gray-600">Monopoly Markets</div>
                </div>
                <div class="bg-white rounded-lg p-6 text-center shadow-sm">
                    <div class="text-3xl font-bold text-red-600 mb-2"><?= $summary['limited'] ?></div>
                    <div class="text-sm text-gray-600">Limited Markets</div>
                </div>
                <div class="bg-white rounded-lg p-6 text-center shadow-sm">
                    <div class="text-3xl font-bold text-blue-600 mb-2"><?= $summary['total'] ?></div>
                    <div class="text-sm text-gray-600">Total Jurisdictions</div>
                </div>
            </div>

            <!-- Federal Framework Overview -->
            <div class="bg-white rounded-lg p-8 mb-8 shadow-sm">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Federal Framework</h3>
                <p class="text-gray-600 mb-6"><?= htmlspecialchars($federalFramework['overview']) ?></p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-3">Federal Responsibilities</h4>
                        <ul class="space-y-2">
                            <?php foreach ($federalFramework['federal_responsibilities'] as $responsibility): ?>
                                <li class="flex items-center text-gray-600">
                                    <svg class="w-5 h-5 text-blue-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <?= htmlspecialchars($responsibility) ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-3">Provincial Jurisdiction</h4>
                        <ul class="space-y-2">
                            <?php foreach ($federalFramework['provincial_jurisdiction'] as $jurisdiction): ?>
                                <li class="flex items-center text-gray-600">
                                    <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <?= htmlspecialchars($jurisdiction) ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Provincial Status Table -->
            <div class="bg-white rounded-lg overflow-hidden shadow-sm mb-8">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-2xl font-bold text-gray-900">Provincial Legal Status</h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Province</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Regulator</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Age Req.</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Market Type</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($provincialData as $code => $province): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <span class="text-sm font-medium text-gray-900"><?= htmlspecialchars($province['province_name']) ?></span>
                                            <span class="ml-2 text-xs text-gray-500">(<?= htmlspecialchars($code) ?>)</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" 
                                              style="background-color: <?= htmlspecialchars($province['status_color']) ?>20; color: <?= htmlspecialchars($province['status_color']) ?>;">
                                            <?= htmlspecialchars($province['legal_status']) ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        <a href="<?= htmlspecialchars($province['regulator_website']) ?>" 
                                           target="_blank" 
                                           class="text-blue-600 hover:text-blue-800">
                                            <?= htmlspecialchars($province['regulator_name']) ?>
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <?= htmlspecialchars($province['age_requirement']) ?>+
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <?= htmlspecialchars($province['market_type']) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Market Statistics -->
            <div class="bg-white rounded-lg p-8 shadow-sm">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Market Statistics</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-blue-600 mb-2">
                            <?= htmlspecialchars($statistics['market_statistics']['total_canadian_players']) ?>
                        </div>
                        <div class="text-sm text-gray-600">Total Canadian Players</div>
                    </div>
                    
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600 mb-2">
                            <?= htmlspecialchars($statistics['market_statistics']['regulated_market_revenue']) ?>
                        </div>
                        <div class="text-sm text-gray-600">Regulated Market Revenue</div>
                    </div>
                    
                    <div class="text-center">
                        <div class="text-2xl font-bold text-orange-600 mb-2">
                            <?= htmlspecialchars($statistics['market_statistics']['problem_gambling_rate']) ?>
                        </div>
                        <div class="text-sm text-gray-600">Problem Gambling Rate</div>
                    </div>
                    
                    <div class="text-center">
                        <div class="text-2xl font-bold text-purple-600 mb-2">
                            <?= htmlspecialchars($statistics['market_statistics']['age_verification_compliance']) ?>
                        </div>
                        <div class="text-sm text-gray-600">Age Verification Compliance</div>
                    </div>
                </div>
            </div>

            <!-- Important Notice -->
            <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-blue-600 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <h4 class="text-lg font-semibold text-blue-900 mb-2">Important Legal Notice</h4>
                        <p class="text-blue-800">
                            Online gambling laws in Canada are complex and vary by province. Always ensure you comply 
                            with your local jurisdiction's regulations. This information is for educational purposes 
                            and should not be considered legal advice.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
