// FILE: src/components/ProDirectory.tsx
import React, { useEffect, useRef, useState } from "react";
import { ChevronLeft, ChevronRight, Search, Star, MapPin, Award, Crown } from "lucide-react";

type Pro = {
  id: string;
  name: string;
  location: string; // e.g., "Cape Town, Western Cape"
  rating: number;
  reviews: number;
  priceRange: string;
  image: string;
  verified: boolean;
  premium: boolean;
  description: string;
};

export const mockPros: Pro[] = [
  {
    id: "1",
    name: "Elegant Memories Photography",
    location: "Cape Town, Western Cape",
    rating: 4.9,
    reviews: 127,
    priceRange: "R15,000 - R35,000",
    image:
      "https://images.pexels.com/photos/1024996/pexels-photo-1024996.jpeg?auto=compress&cs=tinysrgb&w=400",
    verified: true,
    premium: true,
    description:
      "Award-winning wedding photography with a passion for capturing authentic moments.",
  },
  {
    id: "2",
    name: "Blooming Gardens Florist",
    location: "Johannesburg, Gauteng",
    rating: 4.8,
    reviews: 89,
    priceRange: "R8,000 - R25,000",
    image:
      "https://images.pexels.com/photos/1024993/pexels-photo-1024993.jpeg?auto=compress&cs=tinysrgb&w=400",
    verified: true,
    premium: false,
    description: "Exquisite floral arrangements for your special day.",
  },
  {
    id: "3",
    name: "Rhythmic Celebrations DJ",
    location: "Durban, KwaZulu-Natal",
    rating: 4.7,
    reviews: 156,
    priceRange: "R5,000 - R15,000",
    image:
      "https://images.pexels.com/photos/1190297/pexels-photo-1190297.jpeg?auto=compress&cs=tinysrgb&w=400",
    verified: true,
    premium: true,
    description:
      "Professional DJ services with extensive music library and MC services.",
  },
  {
    id: "4",
    name: "Gourmet Wedding Catering",
    location: "Pretoria, Gauteng",
    rating: 4.9,
    reviews: 203,
    priceRange: "R250 - R500 per person",
    image:
      "https://images.pexels.com/photos/958545/pexels-photo-958545.jpeg?auto=compress&cs=tinysrgb&w=400",
    verified: true,
    premium: true,
    description:
      "Exceptional culinary experiences for weddings and special events.",
  },
];

const ProDirectory: React.FC = () => {
  const [searchTerm, setSearchTerm] = useState("");
  const [selectedProvince, setSelectedProvince] = useState("All");

  const rowRef = useRef<HTMLDivElement | null>(null);
  const [canLeft, setCanLeft] = useState(false);
  const [canRight, setCanRight] = useState(true);

  // Extract provinces dynamically from pros
  const provinces = [
    "All",
    ...Array.from(
      new Set(mockPros.map((p) => p.location.split(",")[1].trim()))
    ),
  ];

  // Filter pros based on search & province
  const filteredPros = mockPros.filter((pro) => {
    const q = searchTerm.toLowerCase();
    const matchesSearch = pro.name.toLowerCase().includes(q);
    const province = pro.location.split(",")[1].trim();
    const matchesProvince = selectedProvince === "All" || province === selectedProvince;
    return matchesSearch && matchesProvince;
  });

  // Update arrow state for horizontal scroll
  const updateArrowState = () => {
    const el = rowRef.current;
    if (!el) return;
    const maxScroll = el.scrollWidth - el.clientWidth;
    setCanLeft(el.scrollLeft > 0);
    setCanRight(el.scrollLeft < maxScroll - 1);
  };

  useEffect(() => {
    updateArrowState();
    const el = rowRef.current;
    if (!el) return;
    el.addEventListener("scroll", updateArrowState);
    const onResize = () => updateArrowState();
    window.addEventListener("resize", onResize);
    return () => {
      el.removeEventListener("scroll", updateArrowState);
      window.removeEventListener("resize", onResize);
    };
  }, []);

  // Scroll back to start on filter change
  useEffect(() => {
    if (rowRef.current) rowRef.current.scrollTo({ left: 0, behavior: "smooth" });
  }, [searchTerm, selectedProvince]);

  const scrollByAmount = (dir: "left" | "right") => {
    const el = rowRef.current;
    if (!el) return;
    const amount = Math.round(el.clientWidth * 0.85);
    el.scrollBy({ left: dir === "left" ? -amount : amount, behavior: "smooth" });
  };

  return (
    <div className="bg-gray-50 py-16" id="pros">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {/* Header */}
        <div className="text-center mb-12">
          <h2 className="text-4xl font-bold text-gray-900 mb-4">
            Find Your Perfect Wedding Pros
          </h2>
          <p className="text-xl text-gray-600 max-w-3xl mx-auto">
            Discover verified professionals who will make your special day unforgettable
          </p>
        </div>

        {/* Search + Province */}
        <div className="bg-white rounded-2xl shadow-lg p-6 mb-8">
          <div className="flex flex-col md:flex-row gap-4">
            <div className="relative flex-1">
              <Search className="h-5 w-5 text-gray-400 absolute left-3 top-3" />
              <input
                type="text"
                placeholder="Search pros by name..."
                value={searchTerm}
                onChange={(e) => setSearchTerm(e.target.value)}
                className="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
              />
            </div>
          </div>

          <div className="mt-4 flex flex-wrap gap-2">
            {provinces.map((province) => (
              <button
                key={province}
                onClick={() => setSelectedProvince(province)}
                className={`px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 ${
                  selectedProvince === province
                    ? "bg-pink-500 text-white shadow-lg transform scale-105"
                    : "bg-gray-100 text-gray-700 hover:bg-gray-200"
                }`}
              >
                {province}
              </button>
            ))}
          </div>
        </div>

        {/* Horizontal scroll row */}
        <div className="relative">
          <div className="pointer-events-none absolute inset-y-0 left-0 w-8 bg-gradient-to-r from-gray-50 to-transparent rounded-l-2xl" />
          <div className="pointer-events-none absolute inset-y-0 right-0 w-8 bg-gradient-to-l from-gray-50 to-transparent rounded-r-2xl" />

          <div
            ref={rowRef}
            className="flex gap-6 overflow-x-auto snap-x snap-mandatory scroll-smooth pb-4 scrollbar-hide"
          >
            {filteredPros.map((pro) => (
              <div
                key={pro.id}
                className="min-w-[320px] max-w-[320px] bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden snap-start"
              >
                <div className="relative">
                  <img
                    src={pro.image}
                    alt={pro.name}
                    className="w-full h-44 object-cover"
                  />
                  {pro.premium && (
                    <div className="absolute top-3 left-3 bg-gradient-to-r from-yellow-400 to-yellow-600 text-white px-3 py-1 rounded-full text-xs font-semibold flex items-center space-x-1">
                      <Crown className="h-3 w-3" />
                      <span>Premium</span>
                    </div>
                  )}
                  {pro.verified && (
                    <div className="absolute top-3 right-3 bg-blue-500 text-white p-2 rounded-full">
                      <Award className="h-4 w-4" />
                    </div>
                  )}
                </div>

                <div className="p-5">
                  <div className="flex justify-between items-start mb-2">
                    <div>
                      <h3 className="text-lg font-semibold text-gray-900">{pro.name}</h3>
                      <p className="text-gray-600 text-sm">{pro.location}</p>
                    </div>
                    <div className="flex items-center space-x-1 bg-yellow-50 px-2 py-1 rounded-lg">
                      <Star className="h-4 w-4 text-yellow-500 fill-current" />
                      <span className="text-sm font-semibold text-gray-700">{pro.rating}</span>
                      <span className="text-xs text-gray-500">({pro.reviews})</span>
                    </div>
                  </div>

                  <p className="text-gray-600 text-sm mb-3 line-clamp-2">{pro.description}</p>

                  <div className="text-sm font-medium text-gray-700 mb-4">{pro.priceRange}</div>

                  <div className="flex gap-3">
                    <button className="flex-1 bg-gradient-to-r from-pink-500 to-purple-600 text-white py-2 rounded-xl font-medium hover:from-pink-600 hover:to-purple-700 transition-all">
                      View Profile
                    </button>
                    <button className="flex-1 border border-pink-300 text-pink-600 py-2 rounded-xl font-medium hover:bg-pink-50 transition-colors">
                      Get Quote
                    </button>
                  </div>
                </div>
              </div>
            ))}
          </div>

          {/* Left / Right arrows */}
          <button
            onClick={() => scrollByAmount("left")}
            disabled={!canLeft}
            className="absolute left-2 top-1/2 -translate-y-1/2 bg-white p-2 rounded-full shadow-md disabled:opacity-40"
            aria-label="Scroll left"
          >
            <ChevronLeft className="w-6 h-6" />
          </button>

          <button
            onClick={() => scrollByAmount("right")}
            disabled={!canRight}
            className="absolute right-2 top-1/2 -translate-y-1/2 bg-white p-2 rounded-full shadow-md disabled:opacity-40"
            aria-label="Scroll right"
          >
            <ChevronRight className="w-6 h-6" />
          </button>
        </div>

        {/* CTA */}
        <div className="mt-16 bg-gradient-to-r from-pink-500 to-purple-600 rounded-2xl p-8 text-white text-center">
          <div className="max-w-2xl mx-auto">
            <h3 className="text-2xl font-bold mb-4">Get AI-Powered Pro Matches</h3>
            <p className="text-pink-100 mb-6">
              Let our AI match you with the perfect pros based on your budget, style, and
              requirements
            </p>
            <button className="bg-white text-pink-600 px-8 py-3 rounded-full font-semibold hover:bg-gray-100 transition-transform hover:scale-105">
              Start AI Matching
            </button>
          </div>
        </div>
      </div>
    </div>
  );
};

export default ProDirectory;
