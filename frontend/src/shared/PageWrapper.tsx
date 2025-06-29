'use client';

import { ReactNode } from 'react';
import { cn } from '@/lib/utils';

interface PageWrapperProps {
  children: ReactNode;
  className?: string;
}

export const PageWrapper: React.FC<PageWrapperProps> = ({
  children,
  className = '',
}) => {
  return (
    <div
      className={cn(
        `flex min-h-screen w-full flex-col items-center justify-start ${className}`
      )}
    >
      <div className="w-full max-w-full px-4 sm:px-6 md:px-8 lg:px-10 xl:px-12 2xl:px-16">
        {children}
      </div>
    </div>
  );
};
