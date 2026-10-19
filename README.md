# ReviewPulse AI

> Autonomous customer-review intelligence and AI response management for modern
> e-commerce teams.

ReviewPulse AI turns incoming customer reviews into actionable insight. It
collects reviews through a public API or the dashboard, classifies sentiment,
generates a concise summary and suggested reply, and gives a human operator the
final say before a response is approved or published in demo mode.

This repository contains the Laravel application, its SQLite-ready data model,
the responsive web interface, automated tests, and an optional n8n/Gemini
workflow for external AI processing.

## Contents

- [Features](#features)
- [How it works](#how-it-works)
- [Technology](#technology)
- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Using the application](#using-the-application)
- [Review intake API](#review-intake-api)
- [n8n and Gemini automation](#n8n-and-gemini-automation)
- [Database model](#database-model)
- [Testing](#testing)
- [Project structure](#project-structure)
- [Security notes](#security-notes)
- [Contributing](#contributing)
- [License](#license)

## Features

### Review intelligence

- Accept reviews through `POST /api/reviews` or the authenticated dashboard.
- Analyze star rating and review text with the built-in deterministic NLP
  engine.
- Optionally send analysis through Google Gemini using the exported n8n
  workflow.
- Classify reviews as positive, neutral, or negative with a confidence score.
- Generate a one-sentence summary and an empathetic response draft.

### Operations dashboard

- Overview KPIs for total reviews, average rating, positive percentage,
  negative/risk percentage, and reviews awaiting action.
- Sentiment distribution and star-rating breakdown.
- Date filters for all time, today, the last seven days, and the last 30 days.
- Search and filter the review inbox by customer, product, text, sentiment,
  rating, and workflow status.

### Human-in-the-loop response workspace

- Inspect the original review, customer details, product, source, and analysis.
- Edit the suggested response before it is sent.
- Regenerate a response using professional, empathetic, enthusiastic, or
  apologetic tones.
- Flag a review for human review, approve a reply, and publish in demo mode.
- Keep an audit trail of edits and response actions.

### Automation

- Monitor webhook and processing status from the Automation page.
- Trigger a simulated end-to-end connection test.
- Review payloads, errors, retry counts, and execution status.
- Import the included n8n workflow for Gemini-powered analysis.

## How it works

```text
Customer review or store webhook
             |
             v
      POST /api/reviews
             |
             v
 Laravel review intake and local analysis
             |
             +--> Optional n8n + Google Gemini analysis
             |          |
             |          v
             +---- POST /api/internal/reviews/{id}/analysis
             |
             v
 ReviewPulse dashboard and response workspace
             |
             v
 Human approval and demo-mode publishing
```

ReviewPulse is deliberately human-in-the-loop: AI suggestions are drafts, not
automatic customer communication.

## Technology

- PHP 8.3+
- Laravel 13
- Laravel Sanctum
- SQLite by default, with Laravel's other supported database drivers available
- Blade views
- Tailwind CSS 4
- Vite
- PHPUnit
- Optional n8n and Google Gemini integration

## Requirements

Install the following before starting:

- PHP 8.3 or newer
- Composer 2 or newer
- Node.js 18 or newer and npm
- Git

SQLite is the fastest way to run the project locally. MySQL or PostgreSQL can
also be used by changing the database values in `.env`.

## Installation

Clone the repository and enter the project directory:

```bash
git clone https://github.com/caintcreation/reviewpulse-ai.git
cd reviewpulse-ai
```

Install PHP and JavaScript dependencies:

```bash
composer install
npm install
```

Create the local environment file and application key:

```bash
copy .env.example .env
php artisan key:generate
```

On macOS or Linux, use `cp .env.example .env` instead of `copy`.

Create the SQLite database if it does not already exist, then migrate and seed
the demo data:

```bash
if [ ! -f database/database.sqlite ]; then touch database/database.sqlite; fi
php artisan migrate:fresh --seed
```

On Windows PowerShell:

```powershell
if (-not (Test-Path database\database.sqlite)) { New-Item database\database.sqlite -ItemType File }
php artisan migrate:fresh --seed
```

Build the frontend:

```bash
npm run build
```

Start the application:

```bash
php artisan serve
```

Open [http://localhost:8000](http://localhost:8000). During development, use
the concurrent Laravel, queue, and Vite processes:

```bash
composer run dev
```

If you use Laravel Herd, the application is also available at the Herd site
configured for this directory, such as `http://reviewpulse.test`.

## Configuration

The committed `.env.example` is configured for a zero-configuration SQLite
installation:

```dotenv
DB_CONNECTION=sqlite
SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=database
```

For optional Gemini processing, add a key to your local `.env`:

```dotenv
GEMINI_API_KEY=your_google_ai_studio_key
```

Never commit `.env`, API keys, webhook secrets, or production credentials.
These files and values are excluded from version control by `.gitignore`.

## Using the application

1. Visit `/register` to create a store account, or use the seeded demo account.
2. Open the dashboard to review KPIs and recent activity.
3. Open the Reviews inbox to search and filter incoming reviews.
4. Select a review to open its response workspace.
5. Edit or regenerate the draft, then save, flag, approve, or publish it in
   demo mode.
6. Use Automation to test the pipeline and inspect execution logs.
7. Use Settings to review the store integration details and regenerate its
   webhook secret when necessary.

### Seeded demo account

After running the seeder:

- **Email:** `demo@reviewpulse.test`
- **Password:** `password`
- **Store:** `Caint Electronics`
- **Platform store ID:** `caint-electronics-us`

The seeded password is for local development only. Change it before using any
shared or production environment.

## Review intake API

The public intake endpoint accepts JSON:

```bash
curl -X POST http://localhost:8000/api/reviews \
  -H "Content-Type: application/json" \
  -d '{
    "reviewer_name": "Jane W.",
    "product_name": "Wireless Headphones",
    "rating": 1,
    "review_text": "My headphones arrived late, and the left earbud stopped working after two days."
  }'
```

The intake flow creates a review, analyzes it locally, and makes the result
available in the dashboard. The exact validation and response shape are defined
by `ReviewIntakeController`.

The internal callback used by an external automation pipeline is:

```text
POST /api/internal/reviews/{review}/analysis
```

Protect internal callbacks with the store webhook secret. Do not expose
internal automation credentials in browser code or committed workflow exports.

## n8n and Gemini automation

The optional workflow is exported at
`automation/workflows/review-analysis.json`. Its documented architecture and
import steps are available in `automation/README.md`.

To use it:

1. Start n8n locally:
   ```bash
   n8n start
   ```
   Docker users can run:
   ```bash
   docker run -it --rm --name n8n -p 5678:5678 \
     -v ~/.n8n:/home/node/.n8n n8nio/n8n
   ```
2. Open [http://localhost:5678](http://localhost:5678).
3. Import `automation/workflows/review-analysis.json`.
4. Configure the Google Gemini credential.
5. Configure the callback secret using the store's webhook secret.
6. Activate the workflow and test it from ReviewPulse's Automation page.

## Database model

The migrations create these application tables:

| Table | Purpose |
| --- | --- |
| `stores` | Store identity, platform ID, timezone, and webhook secret |
| `reviews` | Customer reviews, ratings, processing state, sentiment, summaries, and drafts |
| `review_reply_history` | Human edits and response action audit history |
| `automation_logs` | Workflow payloads, status, errors, retries, and linked reviews |

Laravel's standard users, cache, jobs, and personal access token tables are also
included.

## Testing

Run the application test suite:

```bash
php artisan test --compact
```

Or run the Composer test script:

```bash
composer test
```

When changing PHP code, format it with Laravel Pint:

```bash
vendor/bin/pint --dirty --format agent
```

When changing frontend assets, rebuild them:

```bash
npm run build
```

## Project structure

```text
app/
  Http/Controllers/       Web and API request handling
  Models/                 Eloquent models
  Services/               Review analysis and application services
automation/
  workflows/              Exported n8n workflow definitions
database/
  migrations/             Database schema
  seeders/                Local demo data
resources/
  css/                    Tailwind entrypoint
  js/                     Vite entrypoint
  views/                  Blade pages and layouts
routes/
  web.php                 Browser routes
  api.php                 Review intake and automation callbacks
tests/
  Feature/                End-to-end application behavior
  Unit/                   Isolated unit tests
```

## Security notes

- Keep `.env` files and API keys out of Git.
- Use HTTPS and a strong, rotated webhook secret outside local development.
- Treat AI output as untrusted draft content and require human approval.
- Set `APP_DEBUG=false` in production.
- Use a production database, queue worker, cache, and mail provider rather
  than local development defaults.
- Review and restrict CORS, authentication, rate limits, and webhook
  authorization before exposing the intake API publicly.

## Contributing

1. Create a focused branch from `main`.
2. Make the smallest change that solves the problem.
3. Run the relevant PHPUnit tests, Pint, and frontend build.
4. Update documentation when behavior or setup changes.
5. Open a pull request describing the change and verification performed.

## License

This project is intended for private or internal use unless a license is added
by the project owner. Contact the repository owner before redistributing it.
#   r e v i e w p u l s e - a i  
 