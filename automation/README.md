# ReviewPulse AI — Automation & n8n Workflows

This folder contains the automation specifications and exported n8n workflow for ReviewPulse AI.

## Architecture

```
[Customer Review / Webhook]
           │
           ▼
[POST /api/reviews (Laravel)]
           │
           ▼
[n8n Webhook / Internal Pipeline]
           │
           ▼
[Google Gemini AI (or Local NLP Engine)]
           │
           ▼
[POST /api/internal/reviews/{id}/analysis (Callback)]
           │
           ▼
[ReviewPulse Dashboard (Human Review & Demo Publish)]
```

## Importing into n8n

1. Start your local n8n instance:
   ```bash
   n8n start
   # or docker run -it --rm --name n8n -p 5678:5678 -v ~/.n8n:/home/node/.n8n n8nio/n8n
   ```
2. Open `http://localhost:5678` in your browser.
3. In the top-right corner, click **Add Workflow** -> **Import from File...** and select `automation/workflows/review-analysis.json`.
4. Configure Credentials:
   - For the **Gemini AI Analysis** node: add your Google AI Studio Gemini API Key.
   - For the **Save Results to Laravel** node: set header `X-ReviewPulse-Secret` with your store's webhook signing secret.
5. Activate the workflow!
