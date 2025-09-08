# VKRDownloader - Video Download Landing Page

A modern, responsive landing page for VKRDownloader, a video downloading service. This project recreates the design from the provided image with a dark theme, blurred autumn background, and interactive elements.

## Features

- **Modern Design**: Dark theme with glassmorphism effects
- **Responsive Layout**: Works on desktop, tablet, and mobile devices
- **Interactive Elements**: Animated buttons, hover effects, and smooth transitions
- **Platform Support**: Visual representation of supported platforms (YouTube, Facebook, Twitter, Instagram, TikTok, and 1000+ others)
- **URL Validation**: Real-time URL validation with visual feedback
- **Loading States**: Animated loading indicators during processing
- **Notifications**: Toast notifications for user feedback
- **Keyboard Shortcuts**: Ctrl/Cmd + Enter to download, Escape to clear input

## Files Structure

```
├── index.html          # Main HTML structure
├── styles.css          # CSS styling and animations
├── script.js           # JavaScript functionality
└── README.md           # This file
```

## Technologies Used

- **HTML5**: Semantic markup structure
- **CSS3**: Modern styling with flexbox, grid, and animations
- **JavaScript (ES6+)**: Interactive functionality and DOM manipulation
- **Font Awesome**: Icons for platforms and UI elements

## Key Features

### Design Elements
- Blurred autumn leaves background
- Dark header and footer with glassmorphism
- Centered content with rounded corners
- Gradient text effects
- Platform icons with hover animations

### Interactive Features
- URL input with validation
- Download button with loading states
- Platform detection
- Clickable platform items (insert demo URLs)
- Smooth scrolling navigation
- Keyboard shortcuts

### Responsive Design
- Mobile-first approach
- Flexible grid layouts
- Adaptive typography
- Touch-friendly interface

## Usage

1. Open `index.html` in a web browser
2. Enter a video URL in the input field
3. Click the Download button or press Ctrl/Cmd + Enter
4. The system will validate the URL and show appropriate feedback

## Browser Support

- Chrome (recommended)
- Firefox
- Safari
- Edge
- Mobile browsers

## Customization

### Colors
The color scheme can be customized by modifying CSS custom properties in `styles.css`:

```css
:root {
    --primary-color: #007bff;
    --secondary-color: #ffd700;
    --background-dark: rgba(45, 45, 45, 0.9);
    --text-light: #ffffff;
}
```

### Platform Icons
Platform icons are loaded from Font Awesome CDN. To change icons, modify the `platform-icon` classes in the HTML.

### Background
The background uses CSS gradients and SVG patterns. To change the background, modify the `body::before` pseudo-element in `styles.css`.

## Development

### Adding New Platforms
To add support for new platforms:

1. Add the platform pattern to the `supportedPlatforms` object in `script.js`
2. Add the platform icon and styling in `styles.css`
3. Update the platforms grid in `index.html`

### Extending Functionality
The JavaScript is modular and can be extended:

- Add new validation rules
- Implement actual download API calls
- Add more interactive features
- Integrate with analytics services

## License

This project is created for demonstration purposes. Please ensure you have proper rights to use any video downloading functionality in your application.

## Credits

- Design inspired by VKRDownloader
- Icons by Font Awesome
- Created by AI Assistant
