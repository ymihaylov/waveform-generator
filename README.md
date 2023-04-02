# Waveform Generator

## What problem solves?
The waveform-generator project addresses two primary problems:
1. Silence reversal to speech - In a provided audio data containing information about silent sections, silence reversers transform the silence data into audio data, producing a continuous flow of speech segments.
2. Waveform generation - The solution generates waveform data based on the processed audio data from step 2. This data can be used for various purposes, such as rendering a visual representation of the audio information over time or analyzing the audio content for further processing.

In this specific scenario, the solution generates waveform data from two channels - a dialogue between the ```user``` and the ```customer``` and extracts analytical information from the conversation. 

### Input
For example, the input to the solution can be: 
```
[silencedetect @ 0x7fa7edd0c160] silence_start: 1.84
[silencedetect @ 0x7fa7edd0c160] silence_end: 4.48 | silence_duration: 2.64
[silencedetect @ 0x7fa7edd0c160] silence_start: 26.928
```
This is an audio silence detection filter, exported by the ffmpeg audio file. There are two files in this format - one for the user channel and another for the consumer channel.

### Output
An example of the solution's output could be in the following format:
```json
{
  "longest_user_monologue":7.344,
  "longest_customer_monologue":22.448,
  "user_talk_percentage":30.874,
  "user":[
    [0,3.504],[6.656,14],[19.712,20.144],[27.264,36.528],[41.728,47.28],[49.792,61.104],[65.024,79.024]
  ],
  "customer":[
    [0,1.84],[4.48,26.928],[29.184,29.36],[31.744,56.624],[58.624,66.992],[69.632,91.184]
  ]
}
```

## Requirements
- docker
- docker-composer

_The solution doesn't require having PHP, PHPUnit, or a web server installed on your host machine._

## How to use the solution
1. Clone the current repo in a folder of your choice:

```git clone git@github.com:ymihaylov/waveform-generator.git```

2. Go into the repo folder.
3. Run the docker-compose command to build the image and start the container with the project:

```docker-compose up --build```

4. Open http://localhost:8080/ in the browser, or make a GET request from somewhere else to the same URL to see the generated data.
5. By default, the solution works with some predefined silence data (ffmpeg format). Feel free to change it in ```resources/customer-channel.txt``` and ```resources/user-channel.txt``` if you need to.

## Testing the solution
On running container execute the following steps:

1. Locate the ```CONTAINER ID``` for the container that houses the project by running this command:

```docker ps```

You'll get output similar to this:
```
➜  waveform-generator git:(main) ✗ docker ps
CONTAINER ID   IMAGE                    COMMAND                  CREATED          STATUS          PORTS                  NAMES
039e2fea632e   waveform-generator-app   "./docker/php/entryp…"   12 seconds ago   Up 10 seconds   0.0.0.0:8080->80/tcp   waveform-generator-app-1
```
Retrieve the ID from the CONTAINER ID column. 

2. Execute the ```phpunit``` command inside the container from your host machine:

```docker exec -it {{containerId}} ./vendor/bin/phpunit```

Make sure to replace {{containerId}} with the actual ```containerId``` that you found in step 1.