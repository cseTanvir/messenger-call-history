import json
from datetime import datetime
import pandas as pd
import matplotlib.pyplot as plt

# Load the JSON file
with open("messages.json") as f:
    data = json.load(f)

# Get the names of the participants from the JSON file
participants = [participant["name"] for participant in data["participants"]]

# Initialize empty DataFrames to store call data for each participant
call_data = {}
for participant in participants:
    call_data[participant] = pd.DataFrame(columns=["Date", "Sender", "Receiver", "Duration"])

# Process each message in the JSON file
for message in data["messages"]:
    # Check if the message is a call
    if message["type"] == "Call":
        # Get the call duration in seconds
        duration = message["call_duration"]
        # Get the sender's name
        sender = message["sender_name"]
        # Get the receiver's name (the other participant in the call)
        receiver = [participant for participant in participants if participant != sender][0]
        # Convert the timestamp to a datetime object
        date = datetime.fromtimestamp(message["timestamp_ms"] / 1000).strftime("%Y-%m-%d %H:%M:%S")
        # Add the call data to the appropriate DataFrame
        call_data[sender] = call_data[sender].append({"Date": date, "Sender": sender, "Receiver": receiver, "Duration": duration}, ignore_index=True)

# Plot a histogram of call durations for each participant
for participant in participants:
    plt.hist(call_data[participant]["Duration"])
    plt.title(f"Call duration for {participant}")
    plt.xlabel("Duration (seconds)")
    plt.ylabel("Frequency")
    plt.show()

# Print summary statistics for call durations for each participant
for participant in participants:
    duration_sum = call_data[participant]["Duration"].sum()
    duration_hours = duration_sum / 3600
    print(f"Call duration of {participant}: {duration_sum} seconds ({duration_hours} hours)")

# Concatenate the summary statistics for each participant into a single DataFrame
summary_stats = pd.concat([call_data[participant]["Duration"].describe().add_suffix(f"_{participant}") for participant in participants], axis=1)
print(summary_stats)
