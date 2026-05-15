# CHAPTER 7: No-Code Automation with Make.com

If ChatGPT is the "Brain" and Canva is the "Face," then **Make.com** is the "Nervous System." It connects everything so that you don't have to manually copy-paste data between tools.

The best part? You don't need to know a single line of code.

### The "Content Engine" Automation
We are going to build a simple automation that takes a new idea in a Google Sheet and automatically generates a social media caption for it.

#### Step 1: The Trigger (Google Sheets)
*   Create a Google Sheet with columns: "Topic," "Platform," and "AI Draft."
*   In Make.com, create a new Scenario. Select "Google Sheets" and the trigger "Watch Rows."

#### Step 2: The Action (ChatGPT)
*   Connect the Google Sheet to the "OpenAI (ChatGPT)" module.
*   **The Instruction:** "Generate a caption for the topic [Map the Topic column from the sheet] for the platform [Map the Platform column]."

#### Step 3: The Completion (Update Row)
*   Connect ChatGPT back to the "Google Sheets" module.
*   Select the action "Update a Row." Map the response from ChatGPT into the "AI Draft" column.

---

### Why This Is a Game-Changer
Instead of opening ChatGPT 30 times, you just list your 30 topics in a spreadsheet. You hit "Run" in Make.com, and by the time you've finished your coffee, all 30 captions are waiting for you in the sheet.

This is the bridge between "working on your business" and "running a machine."

---

**[Next Step: Chapter 8 — Auto-Posting to Social Media]**
