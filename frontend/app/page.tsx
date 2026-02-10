'use client';
import { useState } from 'react';
import { useDispatch } from 'react-redux';
import { setCredentials } from '@/app/lib/features/auth/authSlice';
import { useRouter } from 'next/navigation';
import axios from 'axios';

export default function LoginPage() {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [loading, setLoading] = useState(false);
  const dispatch = useDispatch();
  const router = useRouter();

  const handleLogin = async (e: React.FormEvent) => {
    e.preventDefault();
    setLoading(true);
    try {
      // MANDATORY: Initialize the CSRF protection session
      await axios.get('http://localhost:8000/sanctum/csrf-cookie', { withCredentials: true });
      
      // Now perform the login
      const response = await axios.post('http://localhost:8000/api/login', 
        { email, password },
        { withCredentials: true } // Ensures cookies are sent/received
      );
      
      dispatch(setCredentials({ 
        user: response.data.user, 
        token: response.data.token 
      }));
      
      router.push('/tasks');
    } catch (error) {
      alert('Login failed. Check your Laravel logs.');
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="flex min-h-screen items-center justify-center bg-gray-100">
      <form onSubmit={handleLogin} className="w-full max-w-md bg-white p-8 rounded shadow-md">
        <h2 className="text-2xl font-bold mb-6 text-center text-black">Task Manager Login</h2>
        <input 
          type="email" 
          placeholder="Email" 
          className="w-full p-2 mb-4 border rounded placeholder-gray-600 text-black"
          value={email}
          onChange={(e) => setEmail(e.target.value)}
          required
        />
        <input 
          type="password" 
          placeholder="Password" 
          className="w-full p-2 mb-4 border rounded placeholder-gray-600 text-black"
          value={password}
          onChange={(e) => setPassword(e.target.value)}
          required
        />
        <button 
          type="submit" 
          disabled={loading}
          className="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700 disabled:bg-blue-300"
        >
          {loading ? 'Authenticating...' : 'Login'}
        </button>
      </form>
    </div>
  );
}