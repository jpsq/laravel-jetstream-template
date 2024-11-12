import { MobileNavItems, NavSection } from '@/types';

// This is sample data.
export const navSections: NavSection[] = [
    {
        heading: 'General',
        navItems: [
            {
                title: 'Documentation',
                icon: 'tabler-book',
                children: [
                    {
                        title: 'Introduction',
                        href: '/docs/introduction',
                    },
                ],
            },
            {
                title: 'Settings',
                icon: 'tabler-settings',
                children: [
                    {
                        title: 'General',
                        href: '#',
                    },
                ],
            },
            {
                title: 'Support',
                href: '#',
                icon: 'tabler-help',
            },
        ],
    },
];

export const mobileNavItems: MobileNavItems = [
    { icon: 'tabler-home', title: 'Home', route:'dashboard' },
];
