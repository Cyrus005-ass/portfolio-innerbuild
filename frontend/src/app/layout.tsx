import './globals.css';
import type { ReactNode } from 'react';

export const metadata = {
  title: 'C-Y Ass | Portfolio',
  description: 'Portfolio statique front-end, sans dépendance backend'
};

export default function RootLayout({ children }: { children: ReactNode }) {
  return (
    <html lang="fr">
      <body>{children}</body>
    </html>
  );
}
