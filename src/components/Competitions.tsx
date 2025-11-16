import React, { useState } from 'react';
import { Trophy, Calendar, Heart, Award, Vote, Camera, Users } from 'lucide-react';
import { Competition } from '../types';

const mockCompetitions: Competition[] = [
  {
    id: '1',
    title: 'Wedding of the Year 2025',
    description: 'Showcase your dream wedding and compete for the ultimate recognition',
    category: 'Overall',
    deadline: '2025-12-31',
    prize: 'R50,000 + Feature Article',
    image: 'https://images.pexels.com/photos/1024993/pexels-photo-1024993.jpeg?auto=compress&cs=tinysrgb&w=600',
    votes: 2847,
    featured: true
  },
  {
    id: '2',
    title: 'Best Traditional Ceremony',
    description: 'Celebrate cultural heritage and traditional wedding ceremonies',
    category: 'Traditional',
    deadline: '2025-11-15',
    prize: 'R25,000 + Cultural Documentary',
    image: 'https://images.pexels.com/photos/1190297/pexels-photo-1190297.jpeg?auto=compress&cs=tinysrgb&w=600',
    votes: 1256,
    featured: false
  },
  {
    id: '3',
    title: 'Most Creative Theme',
    description: 'Show off your unique wedding theme and creative decorations',
    category: 'Creative',
    deadline: '2025-10-30',
    prize: 'R15,000 + Vendor Partnerships',
    image: 'https://images.pexels.com/photos/958545/pexels-photo-958545.jpeg?auto=compress&cs=tinysrgb&w=600',
    votes: 892,
    featured: false
  },
  {
    id: '4',
    title: 'Best Budget Wedding',
    description: 'Prove that beautiful weddings don\'t have to break the bank',
    category: 'Budget',
    deadline: '2025-09-30',
    prize: 'R20,000 + Planning Guide Publication',
    image: 'https://images.pexels.com/photos/1024996/pexels-photo-1024996.jpeg?auto=compress&cs=tinysrgb&w=600',
    votes: 1678,
    featured: true
  }
];

const categories = ['All', 'Overall', 'Traditional', 'Creative', 'Budget', 'Photography', 'Venue'];

const Competitions: React.FC = () => {
  const [selectedCategory, setSelectedCategory] = useState('All');
  const [showSubmission, setShowSubmission] = useState(false);

  const filteredCompetitions = mockCompetitions.filter(comp => 
    selectedCategory === 'All' || comp.category === selectedCategory
  );

  const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('en-US', {
      year: 'numeric',
      month: 'long',
      day: 'numeric'
    });
  };

  return (
    <div className="bg-gradient-to-br from-yellow-50 to-orange-50 py-16" id="competitions">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {/* Header */}
        <div className="text-center mb-12">
          <div className="flex items-center justify-center space-x-2 mb-4">
            <Trophy className="h-8 w-8 text-yellow-600" />
            <h2 className="text-4xl font-bold text-gray-900">Wedding Competitions</h2>
          </div>
          <p className="text-xl text-gray-600 max-w-3xl mx-auto">
            Showcase your special day and compete for amazing prizes while inspiring other couples
          </p>
        </div>

        {/* Category Filters */}
        <div className="flex flex-wrap justify-center gap-2 mb-8">
          {categories.map((category) => (
            <button
              key={category}
              onClick={() => setSelectedCategory(category)}
              className={`px-6 py-3 rounded-full font-medium transition-all duration-200 ${
                selectedCategory === category
                  ? 'bg-yellow-500 text-white shadow-lg transform scale-105'
                  : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200'
              }`}
            >
              {category}
            </button>
          ))}
        </div>

        {/* Competition Grid */}
        <div className="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
          {filteredCompetitions.map((competition) => (
            <div
              key={competition.id}
              className={`bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden ${
                competition.featured ? 'ring-2 ring-yellow-400' : ''
              }`}
            >
              {competition.featured && (
                <div className="bg-gradient-to-r from-yellow-400 to-orange-500 text-white text-center py-2 font-semibold text-sm">
                  Featured Competition
                </div>
              )}
              
              <div className="relative">
                <img
                  src={competition.image}
                  alt={competition.title}
                  className="w-full h-48 object-cover"
                />
                <div className="absolute top-3 left-3 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full">
                  <span className="text-sm font-medium text-gray-700">{competition.category}</span>
                </div>
              </div>

              <div className="p-6">
                <h3 className="text-xl font-semibold text-gray-900 mb-2">{competition.title}</h3>
                <p className="text-gray-600 mb-4">{competition.description}</p>

                <div className="space-y-3 mb-6">
                  <div className="flex items-center text-sm text-gray-500">
                    <Calendar className="h-4 w-4 mr-2" />
                    <span>Deadline: {formatDate(competition.deadline)}</span>
                  </div>
                  <div className="flex items-center text-sm text-green-600 font-medium">
                    <Award className="h-4 w-4 mr-2" />
                    <span>{competition.prize}</span>
                  </div>
                  <div className="flex items-center text-sm text-gray-500">
                    <Vote className="h-4 w-4 mr-2" />
                    <span>{competition.votes.toLocaleString()} votes</span>
                  </div>
                </div>

                <div className="flex space-x-3">
                  <button className="flex-1 bg-gradient-to-r from-yellow-500 to-orange-600 text-white py-3 rounded-xl font-medium hover:from-yellow-600 hover:to-orange-700 transition-all duration-200">
                    Submit Entry
                  </button>
                  <button className="flex-1 border border-yellow-400 text-yellow-600 py-3 rounded-xl font-medium hover:bg-yellow-50 transition-colors">
                    View Entries
                  </button>
                </div>
              </div>
            </div>
          ))}
        </div>

        {/* Submission CTA */}
        <div className="bg-gradient-to-r from-yellow-500 to-orange-600 rounded-2xl p-8 text-white text-center">
          <Trophy className="h-12 w-12 mx-auto mb-4" />
          <h3 className="text-2xl font-bold mb-4">Ready to Share Your Special Day?</h3>
          <p className="text-yellow-100 mb-6 max-w-2xl mx-auto">
            Enter your wedding into our competitions and get a chance to win amazing prizes while inspiring other couples
          </p>
          <button
            onClick={() => setShowSubmission(true)}
            className="bg-white text-yellow-600 px-8 py-3 rounded-full font-semibold hover:bg-gray-100 transition-all duration-200 transform hover:scale-105"
          >
            <Camera className="h-5 w-5 inline mr-2" />
            Submit Your Wedding
          </button>
        </div>

        {/* Submission Modal */}
        {showSubmission && (
          <div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
            <div className="bg-white rounded-2xl shadow-2xl max-w-md w-full max-h-[90vh] overflow-y-auto">
              <div className="p-6">
                <div className="text-center mb-6">
                  <Trophy className="h-12 w-12 text-yellow-500 mx-auto mb-4" />
                  <h3 className="text-xl font-bold text-gray-900">Submit Your Wedding</h3>
                  <p className="text-gray-600">Share your special day with the Knott community</p>
                </div>

                <div className="space-y-4">
                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">Wedding Title</label>
                    <input
                      type="text"
                      placeholder="e.g., John & Sarah's Garden Wedding"
                      className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-yellow-500"
                    />
                  </div>
                  
                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">Competition Category</label>
                    <select className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-yellow-500">
                      <option value="">Select category</option>
                      {categories.slice(1).map((cat) => (
                        <option key={cat} value={cat}>{cat}</option>
                      ))}
                    </select>
                  </div>

                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">Wedding Story</label>
                    <textarea
                      placeholder="Tell us about your special day..."
                      rows={4}
                      className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-yellow-500"
                    />
                  </div>

                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">Upload Photos</label>
                    <div className="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-yellow-400 transition-colors cursor-pointer">
                      <Camera className="h-8 w-8 text-gray-400 mx-auto mb-2" />
                      <p className="text-sm text-gray-600">Click to upload photos or drag and drop</p>
                    </div>
                  </div>

                  <div className="flex space-x-3 pt-4">
                    <button
                      onClick={() => setShowSubmission(false)}
                      className="flex-1 border border-gray-300 text-gray-700 py-3 rounded-xl font-medium hover:bg-gray-50 transition-colors"
                    >
                      Cancel
                    </button>
                    <button className="flex-1 bg-gradient-to-r from-yellow-500 to-orange-600 text-white py-3 rounded-xl font-medium hover:from-yellow-600 hover:to-orange-700 transition-all duration-200">
                      Submit Entry
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        )}
      </div>
    </div>
  );
};

export default Competitions;