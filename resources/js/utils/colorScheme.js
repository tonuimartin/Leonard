// Modern Dark Red/Maroon Color Scheme
export const colors = {
  // Primary maroon/dark red palette
  primary: {
    50: '#fef2f2',   // Very light red
    100: '#fee2e2',  // Light red
    200: '#fecaca',  // Lighter red
    300: '#f87171',  // Medium light red
    400: '#ef4444',  // Medium red
    500: '#dc2626',  // Base red
    600: '#b91c1c',  // Dark red
    700: '#991b1b',  // Darker red
    800: '#7f1d1d',  // Very dark red (main maroon)
    900: '#5f1a1a',  // Deepest maroon
    950: '#450a0a',  // Ultra dark maroon
  },
  
  // Neutral whites and grays
  neutral: {
    50: '#fafafa',   // Pure white
    100: '#f5f5f5',  // Off white
    200: '#e5e5e5',  // Light gray
    300: '#d4d4d4',  // Medium light gray
    400: '#a3a3a3',  // Medium gray
    500: '#737373',  // Base gray
    600: '#525252',  // Dark gray
    700: '#404040',  // Darker gray
    800: '#262626',  // Very dark gray
    900: '#171717',  // Near black
  },
  
  // Accent colors for success, warning, etc.
  success: '#10b981',
  warning: '#f59e0b',
  error: '#ef4444',
  info: '#3b82f6',
}

// CSS Custom Properties for dynamic theming
export const cssVariables = `
  :root {
    --color-primary-50: ${colors.primary[50]};
    --color-primary-100: ${colors.primary[100]};
    --color-primary-200: ${colors.primary[200]};
    --color-primary-300: ${colors.primary[300]};
    --color-primary-400: ${colors.primary[400]};
    --color-primary-500: ${colors.primary[500]};
    --color-primary-600: ${colors.primary[600]};
    --color-primary-700: ${colors.primary[700]};
    --color-primary-800: ${colors.primary[800]};
    --color-primary-900: ${colors.primary[900]};
    --color-primary-950: ${colors.primary[950]};
    
    --color-neutral-50: ${colors.neutral[50]};
    --color-neutral-100: ${colors.neutral[100]};
    --color-neutral-200: ${colors.neutral[200]};
    --color-neutral-300: ${colors.neutral[300]};
    --color-neutral-400: ${colors.neutral[400]};
    --color-neutral-500: ${colors.neutral[500]};
    --color-neutral-600: ${colors.neutral[600]};
    --color-neutral-700: ${colors.neutral[700]};
    --color-neutral-800: ${colors.neutral[800]};
    --color-neutral-900: ${colors.neutral[900]};
    
    --color-success: ${colors.success};
    --color-warning: ${colors.warning};
    --color-error: ${colors.error};
    --color-info: ${colors.info};
  }
`;
