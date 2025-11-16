import React, { useState } from 'react';
import { Sparkles, DollarSign, Users, MapPin, Calendar, Wand2, Star, Crown, Heart, Camera, Music, Utensils, Car, Shield } from 'lucide-react';
import { mockPros } from './ProDirectory';
import { mockVenues } from './VenueDirectory';

const AIMatching: React.FC = () => {
  const [step, setStep] = useState(1);
  const [preferences, setPreferences] = useState({
    budget: '',
    guestCount: '',
    location: '',
    date: '',
    style: '',
    priorities: [] as string[]
  });
  const [isMatching, setIsMatching] = useState(false);
  const [showResults, setShowResults] = useState(false);

  const styles = ['Classic', 'Modern', 'Rustic', 'Bohemian', 'Traditional', 'Luxury'];
  const priorities = [
    { name: 'Photography', icon: Camera },
    { name: 'Catering', icon: Utensils },
    { name: 'Venue', icon: MapPin },
    { name: 'Florals', icon: Heart },
    { name: 'Entertainment', icon: Music },
    { name: 'Transportation', icon: Car }
  ];

  const handleMatch = () => {
    setIsMatching(true);
    setTimeout(() => {
      setIsMatching(false);
      setShowResults(true);
    }, 3000);
  };

  const resetMatching = () => {
    setStep(1);
    setShowResults(false);
    setPreferences({
      budget: '',
      guestCount: '',
      location: '',
      date: '',
      style: '',
      priorities: []
    });
  };

  const renderStep = () => {
    if (showResults) {
      return (
        <div className="space-y-6">
          <div className="text-center mb-6">
            <div className="w-16 h-16 bg-gradient-to-r from-pink-500 to-purple-600 rounded-full mx-auto flex items-center justify-center mb-4">
              <Sparkles className="h-8 w-8 text-white" />
            </div>
            <h3 className="text-2xl font-bold text-gray-900 mb-2">Your Perfect Matches Found!</h3>
            <p className="text-gray-600">Based on your preferences, here are your top AI-generated matches</p>
          </div>
          
          <div className="grid gap-6">
            {/* Top Pro Match */}
            <div className="border-2 border-pink-200 rounded-xl p-6 bg-gradient-to-r from-pink-50 to-purple-50">
              <div className="flex items-center space-x-2 mb-4">
                <Crown className="h-5 w-5 text-yellow-500" />
                <span className="text-sm font-semibold text-pink-600">TOP PRO MATCH</span>
                <span className="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs font-medium">98% Match</span>
              </div>
              <div className="flex items-center space-x-4">
                <img src={mockPros[0].image} alt={mockPros[0].name} className="w-20 h-20 rounded-xl object-cover" />
                <div className="flex-1">
                  <h4 className="font-bold text-gray-900 text-lg">{mockPros[0].name}</h4>
                  <p className="text-pink-600 font-medium">{mockPros[0].category}</p>
                  <div className="flex items-center space-x-1 mt-1">
                    <Star className="h-4 w-4 text-yellow-500 fill-current" />
                    <span className="text-sm text-gray-600">{mockPros[0].rating} ({mockPros[0].reviews} reviews)</span>
                  </div>
                  <div className="text-sm text-gray-500 mt-1">{mockPros[0].location}</div>
                </div>
                <div className="text-right">
                  <div className="text-lg font-bold text-gray-900">{mockPros[0].priceRange}</div>
                  <div className="text-xs text-green-600 font-medium">Perfect Budget Match</div>
                </div>
              </div>
              <div className="flex space-x-3 mt-4">
                <button className="flex-1 bg-gradient-to-r from-pink-500 to-purple-600 text-white py-3 rounded-xl font-medium hover:from-pink-600 hover:to-purple-700 transition-all duration-200">
                  View Full Profile
                </button>
                <button className="flex-1 border border-pink-300 text-pink-600 py-3 rounded-xl font-medium hover:bg-pink-50 transition-colors">
                  Get Instant Quote
                </button>
              </div>
            </div>

            {/* Top Venue Match */}
            <div className="border-2 border-blue-200 rounded-xl p-6 bg-gradient-to-r from-blue-50 to-indigo-50">
              <div className="flex items-center space-x-2 mb-4">
                <Crown className="h-5 w-5 text-yellow-500" />
                <span className="text-sm font-semibold text-blue-600">TOP VENUE MATCH</span>
                <span className="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs font-medium">95% Match</span>
              </div>
              <div className="flex items-center space-x-4">
                <img src={mockVenues[0].image} alt={mockVenues[0].name} className="w-20 h-20 rounded-xl object-cover" />
                <div className="flex-1">
                  <h4 className="font-bold text-gray-900 text-lg">{mockVenues[0].name}</h4>
                  <p className="text-blue-600 font-medium">Premium Venue</p>
                  <div className="flex items-center space-x-1 mt-1">
                    <Star className="h-4 w-4 text-yellow-500 fill-current" />
                    <span className="text-sm text-gray-600">{mockVenues[0].rating} ({mockVenues[0].reviews} reviews)</span>
                  </div>
                  <div className="text-sm text-gray-500 mt-1">{mockVenues[0].location}</div>
                </div>
                <div className="text-right">
                  <div className="text-lg font-bold text-gray-900">{mockVenues[0].priceRange}</div>
                  <div className="text-xs text-blue-600 font-medium">Perfect Capacity: {mockVenues[0].capacity}</div>
                </div>
              </div>
              <div className="flex space-x-3 mt-4">
                <button className="flex-1 bg-gradient-to-r from-blue-500 to-indigo-600 text-white py-3 rounded-xl font-medium hover:from-blue-600 hover:to-indigo-700 transition-all duration-200">
                  View Venue Details
                </button>
                <button className="flex-1 border border-blue-300 text-blue-600 py-3 rounded-xl font-medium hover:bg-blue-50 transition-colors">
                  Check Availability
                </button>
              </div>
            </div>

            {/* Additional Matches */}
            <div className="grid md:grid-cols-2 gap-4">
              {mockPros.slice(1, 3).map((pro, index) => (
                <div key={pro.id} className="border border-gray-200 rounded-xl p-4 bg-white hover:shadow-md transition-shadow">
                  <div className="flex items-center space-x-3">
                    <img src={pro.image} alt={pro.name} className="w-12 h-12 rounded-lg object-cover" />
                    <div className="flex-1">
                      <h5 className="font-semibold text-gray-900 text-sm">{pro.name}</h5>
                      <p className="text-xs text-gray-600">{pro.category}</p>
                      <div className="flex items-center space-x-1 mt-1">
                        <Star className="h-3 w-3 text-yellow-500 fill-current" />
                        <span className="text-xs text-gray-600">{pro.rating}</span>
                      </div>
                    </div>
                    <div className="text-right">
                      <div className="text-sm font-medium text-gray-700">{pro.priceRange.split(' - ')[0]}</div>
                      <div className="text-xs text-green-600">{85 + index * 5}% Match</div>
                    </div>
                  </div>
                </div>
              ))}
            </div>

            <div className="text-center pt-6">
              <button
                onClick={resetMatching}
                className="bg-white border border-pink-300 text-pink-600 px-6 py-3 rounded-xl font-medium hover:bg-pink-50 transition-colors mr-4"
              >
                Start Over
              </button>
              <button className="bg-gradient-to-r from-pink-500 to-purple-600 text-white px-6 py-3 rounded-xl font-medium hover:from-pink-600 hover:to-purple-700 transition-all duration-200">
                View All Matches
              </button>
            </div>
          </div>
        </div>
      );
    }

    switch (step) {
      case 1:
        return (
          <div className="space-y-6">
            <h3 className="text-xl font-semibold text-gray-900">Budget & Guest Information</h3>
            <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">Budget Range</label>
                <div className="relative">
                  <DollarSign className="h-5 w-5 text-gray-400 absolute left-3 top-3" />
                  <select
                    value={preferences.budget}
                    onChange={(e) => setPreferences({ ...preferences, budget: e.target.value })}
                    className="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500"
                  >
                    <option value="">Select budget range</option>
                    <option value="50000-100000">R50,000 - R100,000</option>
                    <option value="100000-200000">R100,000 - R200,000</option>
                    <option value="200000-350000">R200,000 - R350,000</option>
                    <option value="350000+">R350,000+</option>
                  </select>
                </div>
              </div>
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">Guest Count</label>
                <div className="relative">
                  <Users className="h-5 w-5 text-gray-400 absolute left-3 top-3" />
                  <select
                    value={preferences.guestCount}
                    onChange={(e) => setPreferences({ ...preferences, guestCount: e.target.value })}
                    className="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500"
                  >
                    <option value="">Select guest count</option>
                    <option value="50-100">50 - 100 guests</option>
                    <option value="100-200">100 - 200 guests</option>
                    <option value="200-300">200 - 300 guests</option>
                    <option value="300+">300+ guests</option>
                  </select>
                </div>
              </div>
            </div>
            <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">Location</label>
                <div className="relative">
                  <MapPin className="h-5 w-5 text-gray-400 absolute left-3 top-3" />
                  <input
                    type="text"
                    value={preferences.location}
                    onChange={(e) => setPreferences({ ...preferences, location: e.target.value })}
                    placeholder="City or region"
                    className="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500"
                  />
                </div>
              </div>
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">Wedding Date</label>
                <div className="relative">
                  <Calendar className="h-5 w-5 text-gray-400 absolute left-3 top-3" />
                  <input
                    type="date"
                    value={preferences.date}
                    onChange={(e) => setPreferences({ ...preferences, date: e.target.value })}
                    className="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500"
                  />
                </div>
              </div>
            </div>
          </div>
        );
      
      case 2:
        return (
          <div className="space-y-6">
            <h3 className="text-xl font-semibold text-gray-900">Wedding Style & Priorities</h3>
            <div>
              <label className="block text-sm font-medium text-gray-700 mb-3">Preferred Wedding Style</label>
              <div className="grid grid-cols-2 md:grid-cols-3 gap-3">
                {styles.map((style) => (
                  <button
                    key={style}
                    onClick={() => setPreferences({ ...preferences, style })}
                    className={`p-4 rounded-xl border-2 transition-all duration-200 ${
                      preferences.style === style
                        ? 'border-pink-500 bg-pink-50 text-pink-700'
                        : 'border-gray-200 hover:border-gray-300'
                    }`}
                  >
                    <div className="font-medium">{style}</div>
                  </button>
                ))}
              </div>
            </div>
            <div>
              <label className="block text-sm font-medium text-gray-700 mb-3">Top Priorities (Select up to 3)</label>
              <div className="grid grid-cols-2 md:grid-cols-3 gap-3">
                {priorities.map((priority) => {
                  const Icon = priority.icon;
                  return (
                  <button
                    key={priority.name}
                    onClick={() => {
                      const newPriorities = preferences.priorities.includes(priority.name)
                        ? preferences.priorities.filter(p => p !== priority.name)
                        : preferences.priorities.length < 3
                          ? [...preferences.priorities, priority.name]
                          : preferences.priorities;
                      setPreferences({ ...preferences, priorities: newPriorities });
                    }}
                    className={`p-3 rounded-xl border-2 transition-all duration-200 ${
                      preferences.priorities.includes(priority.name)
                        ? 'border-purple-500 bg-purple-50 text-purple-700'
                        : 'border-gray-200 hover:border-gray-300'
                    }`}
                  >
                    <Icon className="h-5 w-5 mx-auto mb-1" />
                    <div className="font-medium text-sm">{priority.name}</div>
                  </button>
                  );
                })}
              </div>
              <div className="text-xs text-gray-500 mt-2">
                Selected: {preferences.priorities.length}/3
              </div>
            </div>
          </div>
        );
      
      case 3:
        return (
          <div className="text-center py-12">
            {isMatching ? (
              <div className="space-y-6">
                <div className="relative">
                  <div className="animate-spin rounded-full h-20 w-20 border-4 border-pink-200 border-t-pink-600 mx-auto"></div>
                  <Wand2 className="h-8 w-8 text-pink-600 absolute inset-0 m-auto animate-pulse" />
                </div>
                <h3 className="text-xl font-semibold text-gray-900">AI is Finding Your Perfect Matches</h3>
                <p className="text-gray-600">Analyzing your preferences and matching with premium vendors...</p>
              </div>
            ) : (
              <div className="space-y-6">
                <div className="w-20 h-20 bg-gradient-to-r from-pink-500 to-purple-600 rounded-full mx-auto flex items-center justify-center">
                  <Sparkles className="h-10 w-10 text-white" />
                </div>
                <h3 className="text-2xl font-bold text-gray-900">Ready to Find Your Perfect Matches?</h3>
                <p className="text-gray-600 max-w-md mx-auto">
                  Our advanced AI will analyze your preferences and match you with premium vendors and venues that perfectly align with your vision, budget, and style.
                </p>
                <div className="bg-white rounded-xl p-4 max-w-md mx-auto">
                  <h4 className="font-semibold text-gray-900 mb-2">Your Preferences Summary:</h4>
                  <div className="text-sm text-gray-600 space-y-1">
                    {preferences.budget && <div>• Budget: {preferences.budget.replace('-', ' - R')}</div>}
                    {preferences.guestCount && <div>• Guests: {preferences.guestCount}</div>}
                    {preferences.location && <div>• Location: {preferences.location}</div>}
                    {preferences.style && <div>• Style: {preferences.style}</div>}
                    {preferences.priorities.length > 0 && <div>• Priorities: {preferences.priorities.join(', ')}</div>}
                  </div>
                </div>
                <div className="flex items-center justify-center space-x-2 text-sm text-gray-500">
                  <Shield className="h-4 w-4" />
                  <span>100% secure and confidential matching</span>
                </div>
                <button
                  onClick={handleMatch}
                  className="bg-gradient-to-r from-pink-500 to-purple-600 text-white px-10 py-4 rounded-full font-bold text-lg hover:from-pink-600 hover:to-purple-700 transition-all duration-200 transform hover:scale-105 shadow-lg"
                >
                  <Wand2 className="h-5 w-5 inline mr-2" />
                  Find My Perfect Matches
                </button>
              </div>
            )}
          </div>
        );
      
      default:
        return null;
    }
  };

  return (
    <div className="bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 py-16" id="ai-matching">
      <div className="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        {/* Header */}
        <div className="text-center mb-12">
          <div className="flex items-center justify-center space-x-2 mb-4">
            <Sparkles className="h-8 w-8 text-purple-600" />
            <h2 className="text-4xl font-bold text-gray-900">AI-Powered Matching</h2>
          </div>
          <p className="text-xl text-gray-600 max-w-2xl mx-auto">
            Let our intelligent system find the perfect vendors and venues tailored specifically to your dream wedding
          </p>
        </div>

        <div className="bg-gradient-to-br from-pink-50 to-purple-50 rounded-3xl p-8 shadow-xl">
          {/* Progress Bar */}
          <div className="flex items-center justify-center space-x-4 mb-10">
            {[
              { num: 1, label: 'Details' },
              { num: 2, label: 'Style' },
              { num: 3, label: 'Match' },
            ].map((stepInfo) => (
              <div key={stepInfo.num} className="flex items-center">
                <div
                  className={`w-12 h-12 rounded-full flex items-center justify-center font-bold transition-all duration-300 ${
                    step >= stepInfo.num || showResults
                      ? 'bg-pink-500 text-white'
                      : 'bg-gray-200 text-gray-500'
                  }`}
                >
                  {stepInfo.num}
                </div>
                <div className="ml-2 mr-4">
                  <div className={`text-sm font-medium ${
                    step >= stepInfo.num || showResults ? 'text-pink-600' : 'text-gray-500'
                  }`}>
                    {stepInfo.label}
                  </div>
                </div>
                {stepInfo.num < 3 && (
                  <div
                    className={`w-20 h-1 rounded-full transition-all duration-300 ${
                      step > stepInfo.num || showResults ? 'bg-pink-500' : 'bg-gray-200'
                    }`}
                  />
                )}
              </div>
            ))}
          </div>

          {/* Content */}
          {renderStep()}

          {/* Navigation */}
          {!showResults && !isMatching && (
            <div className="flex justify-between mt-8">
              <button
                onClick={() => setStep(Math.max(1, step - 1))}
                disabled={step === 1}
                className="px-8 py-3 border-2 border-gray-300 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
              >
                Previous
              </button>
              <button
                onClick={() => step === 3 ? handleMatch() : setStep(step + 1)}
                disabled={
                  (step === 1 && (!preferences.budget || !preferences.guestCount)) ||
                  (step === 2 && (!preferences.style || preferences.priorities.length === 0))
                }
                className="px-8 py-3 bg-gradient-to-r from-pink-500 to-purple-600 text-white rounded-xl font-semibold hover:from-pink-600 hover:to-purple-700 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
              >
                {step === 3 ? 'Find My Matches' : 'Next'}
              </button>
            </div>
          )}
        </div>
      </div>
    </div>
  );
};

export default AIMatching;