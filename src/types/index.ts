export type UserRole = 'couple' | 'pro' | 'venue' | 'negotiator' | 'guest' | 'seller' | 'admin';

export interface User {
  id: string;
  name: string;
  email: string;
  role: UserRole;
  avatar?: string;
  verified?: boolean;
  premium?: boolean;
}

export interface Pro {
  id: string;
  name: string;
  category: string;
  rating: number;
  reviews: number;
  location: string;
  priceRange: string;
  image: string;
  verified: boolean;
  premium: boolean;
  description: string;
}

export interface Venue {
  id: string;
  name: string;
  location: string;
  capacity: string;
  priceRange: string;
  rating: number;
  reviews: number;
  image: string;
  amenities: string[];
  verified: boolean;
  premium: boolean;
}

export interface GiftWellItem {
  id: string;
  title: string;
  description: string;
  targetAmount: number;
  currentAmount: number;
  contributors: number;
  image?: string;
}

export interface Competition {
  id: string;
  title: string;
  description: string;
  category: string;
  deadline: string;
  prize: string;
  image: string;
  votes: number;
  featured: boolean;
}

export interface Negotiator {
  id: string;
  name: string;
  experience: string;
  location: string;
  specialties: string[];
  rating: number;
  reviews: number;
  image: string;
  verified: boolean;
  hourlyRate: string;
}