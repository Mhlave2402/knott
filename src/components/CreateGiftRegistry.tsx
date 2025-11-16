import React, { useState } from 'react';
import { Gift, Plus, X, DollarSign, Heart, Camera, Home, Plane, Car, Music, Utensils, Sparkles } from 'lucide-react';

interface GiftItem {
  id: string;
  title: string;
  description: string;
  targetAmount: number;
  category: string;
  image?: string;
}

const giftCategories = [
  { name: 'Honeymoon', icon: Plane, color: 'blue' },
  { name: 'Home & Living', icon: Home, color: 'green' },
  { name: 'Kitchen & Dining', icon: Utensils, color: 'orange' },
  { name: 'Experience', icon: Sparkles, color: 'purple' },
  { name: 'Transportation', icon: Car, color: 'red' },
  { name: 'Photography', icon: Camera, color: 'pink' },
  { name: 'Entertainment', icon: Music, color: 'yellow' },
  { name: 'Other', icon: Gift, color: 'gray' }
];

const CreateGiftRegistry: React.FC = () => {
  const [showRegistry, setShowRegistry] = useState(false); // toggle form
  const [step, setStep] = useState(1);
  const [coupleInfo, setCoupleInfo] = useState({
    coupleName: '',
    weddingDate: '',
    location: '',
    story: '',
    image: ''
  });
  const [giftItems, setGiftItems] = useState<GiftItem[]>([]);
  const [currentItem, setCurrentItem] = useState<Partial<GiftItem>>({
    title: '',
    description: '',
    targetAmount: 0,
    category: 'Honeymoon'
  });
  const [showAddItem, setShowAddItem] = useState(false);

  const addGiftItem = () => {
    if (currentItem.title && currentItem.targetAmount && currentItem.description) {
      const newItem: GiftItem = {
        id: Date.now().toString(),
        title: currentItem.title,
        description: currentItem.description,
        targetAmount: currentItem.targetAmount,
        category: currentItem.category || 'Other'
      };
      setGiftItems([...giftItems, newItem]);
      setCurrentItem({ title: '', description: '', targetAmount: 0, category: 'Honeymoon' });
      setShowAddItem(false);
    }
  };

  const removeGiftItem = (id: string) => {
    setGiftItems(giftItems.filter(item => item.id !== id));
  };

  const totalGoal = giftItems.reduce((sum, item) => sum + item.targetAmount, 0);

  const renderStep = () => {
    switch (step) {
      case 1:
        return (
          <div className="space-y-6">
            <div className="text-center mb-8">
              <h3 className="text-2xl font-bold text-gray-900 mb-2">Tell Us About Your Wedding</h3>
              <p className="text-gray-600">Let's start with some basic information about your special day</p>
            </div>
            {/* Couple info form */}
            <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">Couple Names</label>
                <input
                  type="text"
                  value={coupleInfo.coupleName}
                  onChange={(e) => setCoupleInfo({ ...coupleInfo, coupleName: e.target.value })}
                  placeholder="e.g., Sarah & Michael"
                  className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
                />
              </div>
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">Wedding Date</label>
                <input
                  type="date"
                  value={coupleInfo.weddingDate}
                  onChange={(e) => setCoupleInfo({ ...coupleInfo, weddingDate: e.target.value })}
                  className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
                />
              </div>
            </div>
            <div>
              <label className="block text-sm font-medium text-gray-700 mb-2">Wedding Location</label>
              <input
                type="text"
                value={coupleInfo.location}
                onChange={(e) => setCoupleInfo({ ...coupleInfo, location: e.target.value })}
                placeholder="e.g., Cape Town, Western Cape"
                className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
              />
            </div>
            <div>
              <label className="block text-sm font-medium text-gray-700 mb-2">Your Love Story (Optional)</label>
              <textarea
                value={coupleInfo.story}
                onChange={(e) => setCoupleInfo({ ...coupleInfo, story: e.target.value })}
                placeholder="Share a bit about your journey together..."
                rows={4}
                className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
              />
            </div>
            <div>
              <label className="block text-sm font-medium text-gray-700 mb-2">Cover Photo URL (Optional)</label>
              <input
                type="url"
                value={coupleInfo.image}
                onChange={(e) => setCoupleInfo({ ...coupleInfo, image: e.target.value })}
                placeholder="https://example.com/your-photo.jpg"
                className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
              />
            </div>
          </div>
        );
      case 2:
        return (
          <div className="space-y-6">
            <div className="text-center mb-8">
              <h3 className="text-2xl font-bold text-gray-900 mb-2">Create Your Gift Items</h3>
              <p className="text-gray-600">Add the things you'd love help with for your wedding and new life together</p>
            </div>
            {/* Gift items list */}
            {giftItems.map((item) => {
              const categoryInfo = giftCategories.find(cat => cat.name === item.category);
              const Icon = categoryInfo?.icon || Gift;
              return (
                <div key={item.id} className="bg-white border border-gray-200 rounded-xl p-4 flex items-center justify-between">
                  <div className="flex items-center space-x-4">
                    <div className={`w-10 h-10 bg-${categoryInfo?.color}-100 rounded-lg flex items-center justify-center`}>
                      <Icon className={`h-5 w-5 text-${categoryInfo?.color}-600`} />
                    </div>
                    <div>
                      <h4 className="font-semibold text-gray-900">{item.title}</h4>
                      <p className="text-sm text-gray-600">{item.description}</p>
                      <p className="text-sm text-gray-500">{item.category}</p>
                    </div>
                  </div>
                  <div className="flex items-center space-x-3">
                    <span className="font-bold text-pink-600">R{item.targetAmount.toLocaleString()}</span>
                    <button
                      onClick={() => removeGiftItem(item.id)}
                      className="p-1 text-red-500 hover:bg-red-50 rounded-full transition-colors"
                    >
                      <X className="h-4 w-4" />
                    </button>
                  </div>
                </div>
              );
            })}
            {/* Add gift item form */}
            {showAddItem ? (
              <div className="bg-gray-50 rounded-xl p-6 space-y-4">
                <h4 className="font-semibold text-gray-900">Add New Gift Item</h4>
                <input
                  type="text"
                  value={currentItem.title}
                  onChange={(e) => setCurrentItem({ ...currentItem, title: e.target.value })}
                  placeholder="Item Title"
                  className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500"
                />
                <input
                  type="number"
                  value={currentItem.targetAmount || ''}
                  onChange={(e) => setCurrentItem({ ...currentItem, targetAmount: parseInt(e.target.value) || 0 })}
                  placeholder="Target Amount"
                  className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500"
                />
                <textarea
                  value={currentItem.description}
                  onChange={(e) => setCurrentItem({ ...currentItem, description: e.target.value })}
                  placeholder="Description"
                  rows={3}
                  className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500"
                />
                <button onClick={addGiftItem} className="bg-pink-500 text-white px-6 py-2 rounded-xl">
                  Add Item
                </button>
                <button onClick={() => setShowAddItem(false)} className="ml-2 border border-gray-300 px-6 py-2 rounded-xl">
                  Cancel
                </button>
              </div>
            ) : (
              <button
                onClick={() => setShowAddItem(true)}
                className="w-full border-2 border-dashed border-gray-300 rounded-xl p-6 text-center"
              >
                <Plus className="h-8 w-8 text-gray-400 mx-auto mb-2" />
                <span className="text-gray-600 font-medium">Add Gift Item</span>
              </button>
            )}
          </div>
        );
      case 3:
        return (
          <div className="space-y-6">
            <div className="text-center mb-8">
              <h3 className="text-2xl font-bold text-gray-900 mb-2">Preview Your Registry</h3>
              <p className="text-gray-600">Review everything before publishing your gift registry</p>
            </div>
            <div className="bg-white border border-gray-200 rounded-2xl overflow-hidden">
              {coupleInfo.image && (
                <img src={coupleInfo.image} alt={coupleInfo.coupleName} className="w-full h-48 object-cover" />
              )}
              <div className="p-6">
                <h3 className="text-2xl font-bold text-gray-900 mb-2">{coupleInfo.coupleName}'s Wedding Registry</h3>
                <p className="text-gray-600 mb-4">Wedding Date: {coupleInfo.weddingDate}</p>
                <p className="text-gray-600 mb-4">Location: {coupleInfo.location}</p>
                <div className="space-y-4">
                  <h4 className="font-semibold text-gray-900">Gift Items ({giftItems.length})</h4>
                  {giftItems.map((item) => {
                    const categoryInfo = giftCategories.find(cat => cat.name === item.category);
                    const Icon = categoryInfo?.icon || Gift;
                    return (
                      <div key={item.id} className="flex items-center space-x-4 p-4 bg-gray-50 rounded-xl">
                        <Icon className="h-5 w-5 text-gray-600" />
                        <div className="flex-1">
                          <h5 className="font-medium text-gray-900">{item.title}</h5>
                          <p className="text-sm text-gray-600">{item.description}</p>
                        </div>
                        <span className="font-bold text-pink-600">R{item.targetAmount.toLocaleString()}</span>
                      </div>
                    );
                  })}
                </div>
              </div>
            </div>
          </div>
        );
      default:
        return null;
    }
  };

  return (
    <div className="bg-gradient-to-br from-pink-50 to-purple-50 py-16" id="create-registry">
      <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        {!showRegistry ? (
          <div className="text-center">
            <button
              onClick={() => setShowRegistry(true)}
              className="px-8 py-3 bg-gradient-to-r from-pink-500 to-purple-600 text-white rounded-xl font-semibold"
            >
              Create Registry
            </button>
          </div>
        ) : (
          <div className="bg-white rounded-3xl p-8 shadow-xl">
            {/* Progress Bar */}
            <div className="flex items-center justify-center space-x-4 mb-10">
              {[{ num: 1, label: 'Wedding Info' }, { num: 2, label: 'Gift Items' }, { num: 3, label: 'Preview' }].map(
                (stepInfo) => (
                  <div key={stepInfo.num} className="flex items-center">
                    <div
                      className={`w-12 h-12 rounded-full flex items-center justify-center font-bold ${
                        step >= stepInfo.num ? 'bg-pink-500 text-white' : 'bg-gray-200 text-gray-500'
                      }`}
                    >
                      {stepInfo.num}
                    </div>
                    <div className="ml-2 mr-4">
                      <div className={`text-sm font-medium ${step >= stepInfo.num ? 'text-pink-600' : 'text-gray-500'}`}>
                        {stepInfo.label}
                      </div>
                    </div>
                    {stepInfo.num < 3 && <div className={`w-20 h-1 ${step > stepInfo.num ? 'bg-pink-500' : 'bg-gray-200'}`} />}
                  </div>
                )
              )}
            </div>

            {/* Content */}
            {renderStep()}

            {/* Navigation */}
            <div className="flex justify-between mt-8">
              <button
                onClick={() => setStep(Math.max(1, step - 1))}
                disabled={step === 1}
                className="px-8 py-3 border-2 border-gray-300 text-gray-700 rounded-xl disabled:opacity-50"
              >
                Previous
              </button>
              {step < 3 ? (
                <button
                  onClick={() => setStep(step + 1)}
                  disabled={
                    (step === 1 && (!coupleInfo.coupleName || !coupleInfo.weddingDate || !coupleInfo.location)) ||
                    (step === 2 && giftItems.length === 0)
                  }
                  className="px-8 py-3 bg-gradient-to-r from-pink-500 to-purple-600 text-white rounded-xl disabled:opacity-50"
                >
                  Next
                </button>
              ) : (
                <button className="px-8 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-xl flex items-center space-x-2">
                  <Heart className="h-5 w-5" />
                  <span>Publish Registry</span>
                </button>
              )}
            </div>
          </div>
        )}
      </div>
    </div>
  );
};

export default CreateGiftRegistry;
