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
    { icon: 'tabler-home', title: 'Accueil', route: 'dashboard' },
    { icon: 'tabler-search', title: 'Search', route: 'profile.show' },
    { icon: 'tabler-bell', title: 'Notifications', route: 'profile.show' },
    { icon: 'tabler-user', title: 'Profile', route: 'profile.show' },
];
