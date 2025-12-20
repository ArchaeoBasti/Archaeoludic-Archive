# The Archaeoludic Archive

A scholarly database cataloging video games that feature archaeology, cultural heritage, and ancient historical themes. This project aims to bridge the gap between game studies and archaeological research by providing a comprehensive, academically-oriented resource with linked open data integration.

## About

The Archaeoludic Archive addresses a gap in scholarly resources by creating a systematic classification of video games dealing with archaeological and ancient historical content. Unlike general gaming databases, this archive employs controlled vocabularies specifically designed for archaeological and cultural heritage themes, connecting games to academic literature and established archaeological thesauri.

## Features

- **Game Database**: Comprehensive catalog of archaeology and heritage-themed video games
- **Controlled Vocabularies**: Specialized classification system including player roles, gameplay modes, and thematic categories
- **API Integrations**: Automatic metadata retrieval from IGDB, Wikidata, Steam, and GOG
- **Bibliography Management**: Zotero integration for scholarly citations in Harvard format
- **Linked Open Data**: Connections to Getty AAT, PeriodO, and Wikidata
- **User Roles**: Public browsing with authenticated editing for scholars

## Tech Stack

- **Framework**: Laravel 11
- **Styling**: Tailwind CSS
- **Database**: MySQL
- **APIs**: IGDB, Zotero, Wikidata, Steam, GOG

## Installation

### Requirements

- PHP 8.3+
- Composer
- Node.js & npm
- MySQL

### Setup

1. Clone the repository:
   ```bash
   git clone https://github.com/YOUR-USERNAME/archaeoludic-archive.git
   cd archaeoludic-archive
   ```

2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Install Node dependencies:
   ```bash
   npm install
   ```

4. Create environment file:
   ```bash
   cp .env.example .env
   ```

5. Configure your `.env` file with database credentials and API keys:
   ```
   DB_DATABASE=your_database
   DB_USERNAME=your_username
   DB_PASSWORD=your_password

   IGDB_CLIENT_ID=your_igdb_client_id
   IGDB_CLIENT_SECRET=your_igdb_client_secret
   ```

6. Generate application key:
   ```bash
   php artisan key:generate
   ```

7. Run database migrations:
   ```bash
   php artisan migrate
   ```

8. Build frontend assets:
   ```bash
   npm run build
   ```

9. Start the development server:
   ```bash
   php artisan serve
   ```

## Contributing

This project is currently in active development. If you're interested in contributing, please get in touch.

## Author

Sebastian Hageneuer  
Berlin-Brandenburg Academy of Sciences and Humanities

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
