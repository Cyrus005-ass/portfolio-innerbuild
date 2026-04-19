import './globals.css';
import type { ReactNode } from 'react';

export const metadata = {
  title: 'C-Y Ass | Portfolio',
  description: 'Portfolio API + Front séparé (migration progressive)'
};

export default function RootLayout({ children }: { children: ReactNode }) {
  return (
    <html lang="fr">
      <body>{children}</body>
    </html>
  );
}
