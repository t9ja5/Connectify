// Constants
const API_BASE_URL = "https://api.videosdk.live";

// Declaring variables
let videoContainer = document.getElementById("videoContainer");
let micButton = document.getElementById("micButton");
let camButton = document.getElementById("camButton");
let copy_meeting_id = document.getElementById("meetingid");
let contentRaiseHand = document.getElementById("contentRaiseHand");
let btnScreenShare = document.getElementById("btnScreenShare");
let videoScreenShare = document.getElementById("videoScreenShare");
let btnRaiseHand = document.getElementById("btnRaiseHand");
// let btnStopPresenting = document.getElementById("btnStopPresenting");
let btnSend = document.getElementById("btnSend");
let participantsList = document.getElementById("participantsList");
let videoCamOff = document.getElementById("main-pg-cam-off");
let videoCamOn = document.getElementById("main-pg-cam-on");

let micOn = document.getElementById("main-pg-unmute-mic");
let micOff = document.getElementById("main-pg-mute-mic");

//recording
let btnStartRecording = document.getElementById("btnStartRecording");
let btnStopRecording = document.getElementById("btnStopRecording");

//videoPlayback DIV
let videoPlayback = document.getElementById("videoPlayback");


// For PreCall
const cameraDeviceDropDown = document.getElementById('cameraDeviceDropDown');
const microphoneDeviceDropDown = document.getElementById('microphoneDeviceDropDown');
const playBackDeviceDropDown = document.getElementById('playBackDeviceDropDown');


let meeting = "";
// Local participants
let localParticipant;
let localParticipantAudio;
let createMeetingFlag = 0;
let joinMeetingFlag = 0;
let token = "";
let micEnable = false;
let webCamEnable = false;
let totalParticipants = 0;
let remoteParticipantId = "";
let participants = [];
// join page
let joinPageWebcam = document.getElementById("joinCam");
let meetingCode = "";
let screenShareOn = false;
let joinPageVideoStream = null;
let cameraPermissionAllowed = true;
let microphonePermissionAllowed = true;
let deviceChangeEventListener;
let joinMeetingName;
const channel1 = new BroadcastChannel('screen-share-channel');


window.addEventListener("load", async function () {
  /*

  const audioPermission = await window.VideoSDK.requestPermission(
    window.VideoSDK.Constants.permission.AUDIO,
  );

  console.log(
    "request Audio Permissions",
    audioPermission.get(window.VideoSDK.Constants.permission.AUDIO)
  );


  const videoPermission = await window.VideoSDK.requestPermission(
    window.VideoSDK.Constants.permission.VIDEO,
  );

  console.log(
    "request Video Permissions",
    videoPermission.get(window.VideoSDK.Constants.permission.VIDEO)
  );

  const audiovideoPermission = await window.VideoSDK.requestPermission(
    window.VideoSDK.Constants.permission.AUDIO_AND_VIDEO,
  );

  console.log(
    "request Audio and Video Permissions",
    audiovideoPermission.get(window.VideoSDK.Constants.permission.AUDIO),
    audiovideoPermission.get(window.VideoSDK.Constants.permission.VIDEO)
  );

  */

  /*

  try {
    const checkAudioPermission = await window.VideoSDK.checkPermissions(
      window.VideoSDK.Constants.permission.AUDIO,
    );
    console.log(
      "Check Audio Permissions",
      checkAudioPermission.get(window.VideoSDK.Constants.permission.AUDIO)
    );
  } catch (e) {
    console.error(e.message);
  }

  try {
    const checkVideoPermission = await window.VideoSDK.checkPermissions(
      window.VideoSDK.Constants.permission.VIDEO,
    );
    console.log(
      "Check Video Permissions",
      checkVideoPermission.get(window.VideoSDK.Constants.permission.VIDEO)
    );
  } catch (e) {
    console.error(e.message);
  }

  try {
    const checkAudioVideoPermission = await window.VideoSDK.checkPermissions(
      window.VideoSDK.Constants.permission.AUDIO_AND_VIDEO,
    );
    console.log(
      "Check Audio Video Permissions",
      checkAudioVideoPermission.get(window.VideoSDK.Constants.permission.VIDEO),
      checkAudioVideoPermission.get(window.VideoSDK.Constants.permission.AUDIO)
    );
  } catch (e) {
    console.error(e.message);
  }

  */

  const requestPermission = await window.VideoSDK.requestPermission(
    window.VideoSDK.Constants.permission.AUDIO_AND_VIDEO,
  );

  console.log(
    "request Audio and Video Permissions",
    requestPermission.get(window.VideoSDK.Constants.permission.AUDIO),
    requestPermission.get(window.VideoSDK.Constants.permission.VIDEO)
  );

  await updateDevices();
  await enableCam();
  await enableMic();

  await window.VideoSDK.getNetworkStats({ timeoutDuration: 120000 })
    .then((result) => {
      console.log("Network Stats : ", result);
    })
    .catch((error) => {
      console.log("Error in Network Stats : ", error);
    });

  deviceChangeEventListener = async (devices) => { // 
    await updateDevices();
    await enableCam();
  }
  window.VideoSDK.on("device-changed", deviceChangeEventListener);
});

async function updateDevices() {
  try {
    const checkAudioVideoPermission = await window.VideoSDK.checkPermissions();

    cameraPermissionAllowed = checkAudioVideoPermission.get(window.VideoSDK.Constants.permission.VIDEO);
    microphonePermissionAllowed = checkAudioVideoPermission.get(window.VideoSDK.Constants.permission.AUDIO);

    if (cameraPermissionAllowed) {
      const cameras = await window.VideoSDK.getCameras();
      cameraDeviceDropDown.innerHTML = "";
      cameras.forEach(item => {
        const option = document.createElement('option');
        option.value = item.deviceId;
        option.text = item.label;
        cameraDeviceDropDown.appendChild(option);
      });

    } else {
      const option = document.createElement('option');
      option.value = "Permission needed";
      option.text = "Permission needed";
      cameraDeviceDropDown.appendChild(option);

      cameraDeviceDropDown.disabled = true;
      cameraDeviceDropDown.setAttribute("style", "cursor:not-allowed")
    }

    if (microphonePermissionAllowed) {
      const microphones = await window.VideoSDK.getMicrophones();
      const playBackDevices = await window.VideoSDK.getPlaybackDevices();
      microphoneDeviceDropDown.innerHTML = "";
      playBackDeviceDropDown.innerHTML = "";

      microphones.forEach(item => {
        const option = document.createElement('option');
        option.value = item.deviceId;
        option.text = item.label;
        microphoneDeviceDropDown.appendChild(option);
      });

      playBackDevices.forEach(item => {
        const option = document.createElement('option');
        option.value = item.deviceId;
        option.text = item.label;
        playBackDeviceDropDown.appendChild(option);
      });

    } else {
      const microphoneDeviceOption = document.createElement('option');
      microphoneDeviceOption.value = "Permission needed";
      microphoneDeviceOption.text = "Permission needed";
      microphoneDeviceDropDown.appendChild(microphoneDeviceOption);

      const playBackDeviceOption = document.createElement('option');
      playBackDeviceOption.value = "Permission needed";
      playBackDeviceOption.text = "Permission needed";
      playBackDeviceDropDown.appendChild(playBackDeviceOption);

      microphoneDeviceDropDown.disabled = true;
      playBackDeviceDropDown.disabled = true;
      microphoneDeviceDropDown.setAttribute("style", "cursor:not-allowed")
      playBackDeviceDropDown.setAttribute("style", "cursor:not-allowed")
    }
  } catch (Ex) {
    console.log("Error in check permission" + Ex);
  }
}

const setAudioOutputDevice = (deviceId) => {
  const audioTags = document.getElementsByTagName("audio");
  for (let i = 0; i < audioTags.length; i++) {
    audioTags.item(i).setSinkId(deviceId);
  }
};


async function tokenGeneration() {
  if (TOKEN != "") {
    token = TOKEN;
    console.log(token);
  } else if (AUTH_URL != "") {
    token = await window
      .fetch(AUTH_URL + "/generateJWTToken")
      .then(async (response) => {
        const { token } = await response.json();
        console.log(token);
        return token;
      })
      .catch(async (e) => {
        console.log(await e);
        return;
      });
  } else if (AUTH_URL == "" && TOKEN == "") {
    alert("Set Your configuration details first ");
    window.location.href = "/";
    // window.location.reload();
  } else {
    alert("Check Your configuration once ");
    window.location.href = "/";
    // window.location.reload();
  }
}

async function validateMeeting(meetingId, joinMeetingName) {
  if (token != "") {
    const url = ${API_BASE_URL}/v2/rooms/validate/${meetingId};

    const options = {
      method: "GET",
      headers: { Authorization: token },
    };

    const result = await fetch(url, options)
      .then((response) => response.json()) //result will have meeting id
      .catch((error) => {
        console.error("error", error);
        alert("Invalid Meeting Id");
        window.location.href = "/";
        return;
      });
    if (result.roomId === meetingId) {
      document.getElementById("meetingid").value = meetingId;
      document.getElementById("joinPage").style.display = "none";
      document.getElementById("gridPpage").style.display = "flex";
      document.getElementById("bottomctrl").style.display = "flex";
      toggleControls();
      startMeeting(token, meetingId, joinMeetingName);
    }
  } else {
    await fetch(
      AUTH_URL + "/validatemeeting/" + meetingId,
      {
        method: "POST",
        headers: {
          Authorization: token,
          "Content-Type": "application/json",
        },
      }
    )
      .then(async (result) => {
        const { meetingId } = await result.json();
        console.log(meetingId);
        if (meetingId == undefined) {
          return alert("Invalid Meeting ID ");
        } else {
          document.getElementById("meetingid").value = meetingId;
          document.getElementById("joinPage").style.display = "none";
          document.getElementById("gridPpage").style.display = "flex";
          document.getElementById("bottomctrl").style.display = "flex";
          toggleControls();
          startMeeting(token, meetingId, joinMeetingName);
        }
      })
      .catch(async (e) => {
        alert("Meeting ID Invalid", await e);
        window.location.href = "/";
        return;
      });
  }
}

function addParticipantToList({ id, displayName }) {
  let participantTemplate = document.createElement("div");
  participantTemplate.className = "row";
  participantTemplate.style.padding = "4px";
  participantTemplate.style.marginTop = "1px";
  participantTemplate.style.marginLeft = "7px";
  participantTemplate.style.marginRight = "7px";
  participantTemplate.style.borderRadius = "3px";
  participantTemplate.style.border = "1px solid rgb(61, 60, 78)";
  participantTemplate.style.backgroundColor = "rgb(0, 0, 0)";

  //icon
  let colIcon = document.createElement("div");
  colIcon.className = "col-2";
  colIcon.innerHTML = "Icon";
  participantTemplate.appendChild(colIcon);

  //name
  let content = document.createElement("div");
  colIcon.className = "coll-3";
  colIcon.innerHTML = ${displayName};
  participantTemplate.appendChild(content);
  // participants.push({ id, displayName });

  console.log(participants);

  participantsList.appendChild(participantTemplate);
  participantsList.appendChild(document.createElement("br"));
}

function createLocalParticipant() {
  totalParticipants++;
  localParticipant = createVideoElement(meeting.localParticipant.id);
  localParticipantAudio = createAudioElement(meeting.localParticipant.id);
  // console.log("localPartcipant.id : ", localParticipant.className);
  // console.log("meeting.localPartcipant.id : ", meeting.localParticipant.id);
  videoContainer.appendChild(localParticipant);
}


async function startMeeting(token, meetingId, name) {
  
  if (joinPageVideoStream !== null) {
    const tracks = joinPageVideoStream.getTracks();
    tracks.forEach((track) => {
      track.stop();
    });
    joinPageVideoStream = null;
    joinPageWebcam.srcObject = null;
  }

  window.VideoSDK.off("device-changed", deviceChangeEventListener);

  // Meeting config
  window.VideoSDK.config(token);
  let customVideoTrack, customAudioTrack;

  if (webCamEnable) {
    customVideoTrack = await window.VideoSDK.createCameraVideoTrack({
      cameraId: cameraDeviceDropDown.value ? cameraDeviceDropDown.value : undefined,
      optimizationMode: "motion",
      multiStream: false,
    });
  }

  if (micEnable) {
    customAudioTrack = await window.VideoSDK.createMicrophoneAudioTrack({
      microphoneId: microphoneDeviceDropDown.value ? microphoneDeviceDropDown.value : undefined,
      encoderConfig: "high_quality",
      noiseConfig: {
        noiseSuppresion: true,
        echoCancellation: true,
        autoGainControl: true,
      },
    });
  }

  // Meeting Init
  meeting = window.VideoSDK.initMeeting({
    meetingId: meetingId, // required
    name: name, // required
    micEnabled: micEnable, // optional, default: true
    webcamEnabled: webCamEnable, // optional, default: true
    maxResolution: "hd", // optional, default: "hd"
    customCameraVideoTrack: customVideoTrack,
    customMicrophoneAudioTrack: customAudioTrack,
  });

  participants = meeting.participants;
  console.log("meeting obj : ", meeting);
  // Meeting Join
  meeting.join();

  //create Local Participant
  createLocalParticipant();

  //add yourself in participant list
  if (totalParticipants != 0)
    addParticipantToList({
      id: meeting.localParticipant.id,
      displayName: You (${joinMeetingName}),
    });

  // Setting local participant stream
  meeting.localParticipant.on("stream-enabled", (stream) => {
    setTrack(
      stream,
      localParticipantAudio,
      meeting.localParticipant,
      (isLocal = true)
    );
    console.log("webcam used : ", meeting.selectedCameraDevice);
    console.log("microphone used : ", meeting.selectedMicrophoneDevice);
  });

  meeting.localParticipant.on("stream-disabled", (stream) => {
    if (stream.kind == "video") {
      videoCamOn.style.display = "none";
      videoCamOff.style.display = "inline-block";
    }
    if (stream.kind == "audio") {
      micOn.style.display = "none";
      micOff.style.display = "inline-block";
    }
    console.log("webcam used : ", meeting.selectedCameraDevice);
    console.log("microphone used : ", meeting.selectedMicrophoneDevice);
  });

  meeting.on("meeting-joined", () => {
    meeting.pubSub.subscribe("CHAT", (data) => {
      let { message, senderId, senderName, timestamp } = data;
      const chatBox = document.getElementById("chatArea");
      const chatTemplate = `
          <div style="margin-bottom: 10px; color: black; right: -5px; position: relative;${meeting.localParticipant.id == senderId && "text-align : right; left: -5px;"
        }">
            <span style="font-size:12px;">${senderName}</span>
            <div style="margin-top:5px">
              <span style="background:${meeting.localParticipant.id == senderId ? "grey" : "crimson"
        };color:white;padding:5px;border-radius:8px">${message}<span>
            </div>
          </div>
          `;
      chatBox.insertAdjacentHTML("beforeend", chatTemplate);
    });

  });

  meeting.on("meeting-left", () => {
    window.location.reload();
    document.getElementById("join-page").style.display = "flex";
  });

  // Other participants
  meeting.on("participant-joined", (participant) => {
    
    totalParticipants++;
    if(totalParticipants >= 6)
    {}

    let videoElement = createVideoElement(participant.id);
    console.log("Video Element Created");
    let resizeObserver = new ResizeObserver(() => {
      participant.setViewPort(
        videoElement.offsetWidth,
        videoElement.offsetHeight
      );
    });
    resizeObserver.observe(videoElement);
    let audioElement = createAudioElement(participant.id);
    remoteParticipantId = participant.id;

    participant.on("stream-enabled", (stream) => {
      setTrack(stream, audioElement, participant, (isLocal = false));
    });
    
    videoContainer.appendChild(videoElement);
    console.log("Video Element Appended");
    videoContainer.appendChild(audioElement);
    addParticipantToList(participant);
    setAudioOutputDevice(playBackDeviceDropDown.value);
    notifyUserJoined(${participant.displayName} has joined the meeting.);
  });

  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // let currentIndex = 0;
  // const participantsPerPage = 6;
  // const videoWrapper = document.querySelector('.video-wrapper');
  
  // function showNextParticipants() {
  //     const totalParticipants = videoWrapper.children.length;
  //     const maxIndex = Math.ceil(totalParticipants / participantsPerPage) - 1;
  //     if (currentIndex < maxIndex) {
  //         currentIndex++;
  //         updateVideoWrapperTransform();
  //     }
  // }
  
  // function showPreviousParticipants() {
  //     if (currentIndex > 0) {
  //         currentIndex--;
  //         updateVideoWrapperTransform();
  //     }
  // }
  
  
  // function updateVideoWrapperTransform() {
  //     const offset = currentIndex * 100;
  //     videoWrapper.style.transform = translate(-${offset}%);
  // }
  // // Add event listeners for swipe functionality
  // let startX;
  
  // videoWrapper.addEventListener('touchstart', (e) => {
  //     startX = e.touches[0].clientX;
  // });
  
  // videoWrapper.addEventListener('touchmove', (e) => {
  //     const moveX = e.touches[0].clientX;
  //     if (startX - moveX > 50) {
  //         showNextParticipants();
  //     } else if (moveX - startX > 50) {
  //         showPreviousParticipants();
  //     }
  // });

  //   let currentIndex = 0;
  // const participantsPerPage = 6;
  // const videoWrapper = document.querySelector('.video-wrapper');

  // function showNextParticipants() {
  //     const totalParticipants = videoWrapper.children.length;
  //     const maxIndex = Math.ceil(totalParticipants / participantsPerPage) - 1;
  //     if (currentIndex < maxIndex) {
  //         currentIndex++;
  //         updateVideoWrapperTransform1();
  //     }
  // }

  // function showPreviousParticipants() {
  //     if (currentIndex > 0) {
  //         currentIndex--;
  //         updateVideoWrapperTransform1();
  //     }
  // }

  // function updateVideoWrapperTransform() {
  //     const offset = currentIndex * 100;
  //     videoWrapper.style.transform = translateX(-${offset}%); // Translate vertically
  // }
  // function updateVideoWrapperTransform1() {
  //   const offset = currentIndex * 100;
  //   videoWrapper.style.transform = translateY(-${offset}%); // Translate vertically
  // }

  // // Add event listeners for swipe functionality
  // let startY;

  // videoWrapper.addEventListener('touchstart', (e) => {
  //     startY = e.touches[0].clientY; // Store initial touch Y position
  // });

  // videoWrapper.addEventListener('touchmove', (e) => {
  //     const moveY = e.touches[0].clientY; // Get current touch Y position
  //     if (startY - moveY > 50) {
  //         showNextParticipants(); // Swipe up
  //     } else if (moveY - startY > 50) {
  //         showPreviousParticipants(); // Swipe down
  //     }
  // });

  //   document.getElementById('next-button').addEventListener('click', showNextParticipants);
  //   document.getElementById('prev-button').addEventListener('click', showPreviousParticipants);
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // participants left

  meeting.on("participant-left", (participant) => {
    totalParticipants--;
    let vElement = document.getElementById(v-${participant.id});
    vElement.parentNode.removeChild(vElement);

    let aElement = document.getElementById(a-${participant.id});
    aElement.parentNode.removeChild(aElement);
    //remove it from participant list participantId;
    notifyUserJoined(${participant.displayName} has left the meeting.);
    document.getElementById(p-${participant.id}).remove();
    
  });

  //recording events
  meeting.on("recording-started", () => {
    console.log("RECORDING STARTED EVENT");
    btnStartRecording.style.display = "none";
    btnStopRecording.style.display = "inline-block";
  });
  meeting.on("recording-stopped", () => {
    console.log("RECORDING STOPPED EVENT");
    btnStartRecording.style.display = "inline-block";
    btnStopRecording.style.display = "none";
  });

  meeting.on("presenter-changed", (presenterId) => {
    if (presenterId) {
      console.log(presenterId);
      notifyUserJoined(${presenterId} is sharing his screen.);
      
    } else {
      console.log(presenterId);
      videoScreenShare.removeAttribute("src");
      videoScreenShare.pause();
      videoScreenShare.load();
      videoScreenShare.style.display = "none";

      btnScreenShare.style.color = "white";
      screenShareOn = false;
      channel1.postMessage({ type: 'SCREEN_SHARE_STOPPED' });
      console.log(screen share on : ${screenShareOn});
    }
  });


  // Create a Broadcast Channel to communicate between tabs
const channel = new BroadcastChannel('active-speaker');
const localParticipan = meeting.localParticipant.id ;

// Listen for speaker changes
meeting.on("speaker-changed", (localParticipan) => {
  // Broadcast the active speaker ID to all participants
  channel.postMessage(localParticipan);
  console.log(Local participant ID: ${localParticipan});
});

// Listen for broadcast messages
channel.onmessage = (event) => {
  // Get the active speaker ID from the message
  const activeSpeakerId = event.data;

  // Remove the green border from all video elements
  document.querySelectorAll("video").forEach((video) => {
    video.style.border = "";
  });

  // Get the video element of the active speaker
  const activeSpeakerVideo = document.getElementById(v-${activeSpeakerId});

  // Add a green border to the video element
  activeSpeakerVideo.style.border = "5px solid green";
};
  // meeting.on("speaker-changed",() => {
  //   console.log(${meeting.localParticipant.id});
  //   // Get the video element of the active speaker
  //   const activeSpeakerVideo = document.getElementById(v-${meeting.localParticipant.id});
  
  //   // Add a green border to the video element
  //   activeSpeakerVideo.style.border = "2px solid green";
  
  //   // Remove the green border from other video elements
  //   document.querySelectorAll("video").forEach((video) => {
  //     if (video.id !== v-${meeting.localParticipant.id}) {
  //       video.style.border = "";
  //     }
  //   });
  // });
  
  
  //add DOM Events
  addDomEvents();
}

// joinMeeting();
async function joinMeeting(newMeeting) {
  // get Token
  document.getElementById("sux").style.display = "none";
  tokenGeneration();

  joinMeetingName =  document.getElementById("sexy").value || "";
  let meetingId = document.getElementById("joinMeetingId").value || "";
  if (!meetingId && !newMeeting) {
    return alert("Please Provide a meetingId");
  }

  if (!newMeeting) {
    validateMeeting(meetingId, joinMeetingName);
  }

  //create New Meeting
  //get new meeting if new meeting requested;
  if (newMeeting && TOKEN != "") {
    const url = ${API_BASE_URL}/v2/rooms;
    const options = {
      method: "POST",
      headers: { Authorization: token, "Content-Type": "application/json" },
    };

    const { roomId } = await fetch(url, options)
      .then((response) => response.json())
      .catch((error) => alert("error", error));

    if (roomId) {
      document.getElementById("meetingid").value = roomId;
      document.getElementById("joinPage").style.display = "none";
      document.getElementById("gridPpage").style.display = "flex";
      document.getElementById("bottomctrl").style.display = "flex";
      toggleControls();
      startMeeting(token, roomId, joinMeetingName);
    }
  } else if (newMeeting && TOKEN == "") {
    const options = {
      method: "POST",
      headers: {
        Authorization: token,
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ token }),
    };

    meetingId = await fetch(AUTH_URL + "/createMeeting", options).then(
      async (result) => {
        console.log("result of create meeting : ", result);
        const { meetingId } = await result.json();
        console.log("NEW MEETING meetingId", meetingId);
        return meetingId;
      }
    );
    if (meetingId) {
      document.getElementById("meetingid").value = meetingId;
      document.getElementById("joinPage").style.display = "none";
      document.getElementById("gridPpage").style.display = "flex";
      document.getElementById("bottomctrl").style.display = "flex";
      toggleControls();
      startMeeting(token, meetingId, joinMeetingName);
    }
  }
}

// creating video element
function createVideoElement(pId) {
  let division;

  division = document.createElement("div");
  division.setAttribute("id", "video-frame-container");
  division.className = v-${pId};
  let videoElement = document.createElement("video");
  videoElement.classList.add("video-frame");
  videoElement.setAttribute("id", v-${pId});
  videoElement.setAttribute("playsinline", true);
  //videoElement.setAttribute('height', '300');
  videoElement.setAttribute("width", "300");

  division.appendChild(videoElement);

  return videoElement;
}

// creating audio element
function createAudioElement(pId) {
  let audioElement = document.createElement("audio");
  audioElement.setAttribute("autoPlay", "false");
  audioElement.setAttribute("playsInline", "true");
  audioElement.setAttribute("controls", "false");
  audioElement.setAttribute("id", a-${pId});
  return audioElement;
}

//setting up tracks

function setTrack(stream, audioElement, participant, isLocal) {
  if (stream.kind == "video") {
    console.log("setTrack called...");
    if (isLocal) {
      videoCamOff.style.display = "none";
      videoCamOn.style.display = "inline-block";
    }
    const mediaStream = new MediaStream();
    mediaStream.addTrack(stream.track);
    let videoElm = document.getElementById(v-${participant.id});
    videoElm.srcObject = mediaStream;
    videoElm
      .play()
      .catch((error) =>
        console.error("videoElem.current.play() failed", error)
      );
    participant.setViewPort(videoElm.offsetWidth, videoElm.offsetHeight);
  }
  if (stream.kind == "audio") {
    if (isLocal) {
      micOff.style.display = "none";
      micOn.style.display = "inline-block";
      return;
    }
    const mediaStream = new MediaStream();
    mediaStream.addTrack(stream.track);
    audioElement.srcObject = mediaStream;
    audioElement
      .play()
      .catch((error) => console.error("audioElem.play() failed", error));
  }
  if (stream.kind == "share" && !isLocal) {
    screenShareOn = true;
    const mediaStream = new MediaStream();
    mediaStream.addTrack(stream.track);
    videoScreenShare.srcObject = mediaStream;
    videoScreenShare
      .play()
      .catch((error) =>
        console.error("videoElem.current.play() failed", error)
      );
     
    videoScreenShare.style.display = "block";
    btnScreenShare.style.color = "grey";
  }
}

//add button events once meeting is created
function addDomEvents() {
  // mic button event listener
  micOn.addEventListener("click", () => {
    console.log("Mic-on pressed");
    meeting.muteMic();
  });

  micOff.addEventListener("click", async () => {
    console.log("Mic-f pressed");
    if (microphonePermissionAllowed) {
      meeting.unmuteMic();
    } else {
      console.log("Audio : Permission not granted");
    }
  });

  videoCamOn.addEventListener("click", async () => {
    meeting.disableWebcam();
  });

  videoCamOff.addEventListener("click", async () => {
    if (cameraPermissionAllowed) {
      meeting.enableWebcam();
    } else {
      console.log("Camera : Permission not granted");
    }
  });

  
  btnScreenShare.addEventListener("click", async () => {
    // ...
    if (btnScreenShare.style.color == "grey") {
      meeting.disableScreenShare();
      console.log("d");
    } else {
      meeting.enableScreenShare();
      console.log("di");
    channel1.postMessage({ type: 'SCREEN_SHARE_STARTED' });

    }
    // ...
  });
  channel1.addEventListener('message', (event) => {
    if (event.data.type === 'SCREEN_SHARE_STARTED') {
      console.log("hi");
      // Update the video container styles here
      updateVideoContainerStyles();
    }
    if(event.data.type === "SCREEN_SHARE_STOPPED" ){
      console.log("stop");
      const videoContainers = document.querySelectorAll('#vc');
      videoContainers.forEach((container) => {
        container.style.width = 'auto';
        // container.style.height = '500px';
        container.style.position = 'relative';
        container.style.left = 'auto';
        // Add any other styles you need to update
      });
    }
  });
  function updateVideoContainerStyles() {
    const videoContainers = document.querySelectorAll('#vc');
    videoContainers.forEach((container) => {
      container.style.width = '70%';
      // container.style.height = '500px';
      container.style.position = 'relative';
      container.style.left = '57%';
      // Add any other styles you need to update
    });
  }
  // screen share button event listener
  btnScreenShare.addEventListener("click", async () => {
    
  });

  //raise hand event
  // const raiseHandBtn = document.getElementById("btnRaiseHand");
  // raiseHandBtn.addEventListener("click", () => {
  //   const topic = "RAISE_HAND";
  
  //   meeting?.pubSub.publish(topic, "Raise Hand");
  //   raiseHand();
  // });
  // function raiseHand(){
  
  
  //   if (meeting.localParticipant.mode == "CONFERENCE") {
  //     window.alert(${joinMeetingName} raise hand);
  //   }
  
  
  // meeting?.pubSub?.subscribe("RAISE_HAND", raiseHand);

  // }
//   const channel = new BroadcastChannel('raiseHandChannel');
//   const raiseHandBtn = document.getElementById("btnRaiseHand");
//   raiseHandBtn.addEventListener("click", () => {
//     const topic = "RAISE_HAND";
//     // Publish the message through the broadcast channel
//     channel.postMessage({ topic: topic, message: "Raise Hand" });
//     raiseHand(); // Call raiseHand locally
//   });
// // Listen for messages on the broadcast channel
// channel.addEventListener('message', event => {
//   const { topic, message } = event.data;
//   if (topic === 'RAISE_HAND') {
//     raiseHand(); // Call raiseHand to handle the event
//   }
// });
// function raiseHand() {
//   if (meeting.localParticipant.mode === "CONFERENCE") {
//     window.alert(${joinMeetingName} raise hand);
//   }
// }
// Create a broadcast channel
const channel = new BroadcastChannel('myChannel');

// Example sending message
const raiseHandBtn = document.getElementById('btnRaiseHand');
raiseHandBtn.addEventListener('click', () => {
  const message = {
    topic: 'RAISE_HAND',
    content: joinMeetingName
  };
  channel.postMessage(message);
});

// Example receiving message
channel.addEventListener('message', event => {
  const { topic, content } = event.data;
  if (topic === 'RAISE_HAND') {
    handleRaiseHand(content);
  }
});

function handleRaiseHand(content) {
  notifyUserJoined(${conten} has raised hand.);
  // alert(`${content} raised hand `);
  // Handle the raise hand event here
}

// Close the channel when done
// channel.close();

  
  //send chat message button
  btnSend.addEventListener("click", async () => {
    const message = document.getElementById("txtChat").value;
    console.log("publish : ", message);
    document.getElementById("txtChat").value = "";
    meeting.pubSub
      .publish("CHAT", message, { persist: true })
      .then((res) => console.log(response of publish : ${res}))
      .catch((err) => console.log(error of publish : ${err}));
    // meeting.sendChatMessage(JSON.stringify({ type: "chat", message }));
  });

  // //leave Meeting Button
  $("#leaveCall").click(async () => {
    participants = new Map(meeting.participants);
    meeting.leave();
  });

  //end meeting button
  $("#endCall").click(async () => {
    meeting.end();
  });

  // //startRecording
  btnStartRecording.addEventListener("click", async () => {
    console.log("btnRecording is clicked");
    meeting.startRecording();
  });
  // //Stop Recording
  btnStopRecording.addEventListener("click", async () => {
    meeting.stopRecording();
  });
}

async function toggleMic() {
  console.log("micEnable", micEnable);
  if (micEnable) {
    // document.getElementById("micButton").style.backgroundColor = "red";
    document.getElementById("muteMic").style.display = "inline-block";
    document.getElementById("unmuteMic").style.display = "none";
    micEnable = false;
  } else {
    enableMic();
  }
}
async function toggleWebCam() {
  console.log("joinPageVideoStream", joinPageVideoStream);
  if (joinPageVideoStream) {
    joinPageWebcam.style.backgroundColor = "black";
    joinPageWebcam.srcObject = null;
    // document.getElementById("camButton").style.backgroundColor = "red";
    document.getElementById("offCamera").style.display = "inline-block";
    document.getElementById("onCamera").style.display = "none";
    webCamEnable = false;
    const tracks = joinPageVideoStream.getTracks();
    tracks.forEach((track) => {
      track.stop();
    });
    joinPageVideoStream = null;
  } else {
    enableCam();
  }
}

async function enableCam() {
  if (joinPageVideoStream !== null) {
    const tracks = joinPageVideoStream.getTracks();
    tracks.forEach((track) => {
      track.stop();
    });
    joinPageVideoStream = null;
    joinPageWebcam.srcObject = null;
  }

  if (cameraPermissionAllowed) {
    let mediaStream;
    try {
      mediaStream = await window.VideoSDK.createCameraVideoTrack({
        cameraId: cameraDeviceDropDown.value ? cameraDeviceDropDown.value : undefined,
        optimizationMode: "motion",
        multiStream: false,
      });
    } catch (ex) {
      console.log("Exception in enableCam", ex);
    }

    if (mediaStream) {
      joinPageVideoStream = mediaStream;
      joinPageWebcam.srcObject = mediaStream;
      joinPageWebcam.play().catch((error) =>
        console.log("videoElem.current.play() failed", error)
      );
      document.getElementById("camButton").style.backgroundColor = "#DCDCDC";
      document.getElementById("offCamera").style.display = "none";
      document.getElementById("onCamera").style.display = "inline-block";
      webCamEnable = true;
    }

  }
}

async function enableMic() {
  if (microphonePermissionAllowed) {
    micEnable = true;
    document.getElementById("micButton").style.backgroundColor = "#DCDCDC";
    document.getElementById("muteMic").style.display = "none";
    document.getElementById("unmuteMic").style.display = "inline-block";
  }
}


function copyMeetingCode() {
  copy_meeting_id.select();
  document.execCommand("copy");
}

//open participant wrapper
function openParticipantWrapper() {
  document.getElementById("participants").style.display = "block";
  document.getElementById("participants").style.width = "350px";
  document.getElementById("videoContainer").style.marginRight = "350px";
  document.getElementById("ParticipantsCloseBtn").style.visibility = "visible";
  document.getElementById("totalParticipants").style.visibility = "visible";
  document.getElementById("totalParticipants").innerHTML = Participants (${totalParticipants});
}

function closeParticipantWrapper() {
  document.getElementById("participants").style.width = "0";
  document.getElementById("participants").style.display = "none";
  document.getElementById("videoContainer").style.marginRight = "0";
  document.getElementById("ParticipantsCloseBtn").style.visibility = "hidden";
  document.getElementById("totalParticipants").style.visibility = "hidden";
}

function openChatWrapper() {
  document.getElementById("chatModule").style.display = "block";
  document.getElementById("chatModule").style.width = "350px";
   document.getElementById("videoContainer").style.marginRight = "350px";
  document.getElementById("chatCloseBtn").style.visibility = "visible";
  document.getElementById("chatHeading").style.visibility = "visible";
  document.getElementById("btnSend").style.display = "inline-block";
}

function closeChatWrapper() {
  document.getElementById("chatModule").style.width = "0";
  document.getElementById("chatModule").style.display = "none";
  document.getElementById("videoContainer").style.marginRight = "0";
  document.getElementById("chatCloseBtn").style.visibility = "hidden";
  document.getElementById("btnSend").style.display = "none";
}

function toggleControls() {
  console.log("from toggleControls");
  if (micEnable) {
    console.log("micEnable True");
    micOn.style.display = "inline-block";
    micOff.style.display = "none";
  } else {
    console.log("micEnable False");
    micOn.style.display = "none";
    micOff.style.display = "inline-block";
  }

  if (webCamEnable) {
    console.log("webCamEnable True");
    videoCamOn.style.display = "inline-block";
    videoCamOff.style.display = "none";
  } else {
    console.log("webCamEnable False");
    videoCamOn.style.display = "none";
    videoCamOff.style.display = "inline-block";
  }
}


// Assume meeting is initialized and participants are joined

// meeting.on("speaker-changed", (meeting.localParticipant.id) => {
//   // Get the video element of the active speaker


//   // Remove the green border from other video elements
//   document.querySelectorAll("video-frane").forEach((video) => {
//     if (video.id === v-${meeting.localParticipant.id}) {
//       document.getElementById(".video-frame").style.border= "2px solid green";
     
//     }
//     if(video.id !== v-${meeting.localParticipant.id}){
//       video.style.border = "1px solid lightslategrey";
//     }
//   });
// });

// Assume meeting is initialized and participants are joined


// Assume you have a meeting object with a start method


// // Assume you have a meeting object with a playback method
// meeting.playback(recordingId).then(() => {
//   // Get the playback stream
//   const playbackStream = meeting.getPlaybackStream();

//   // Create a new video element to display the playback
//   const videoElement = document.createElement("video");
//   videoElement.srcObject = playbackStream;
//   videoElement.play();

//   // Add the video element to the page
//   document.body.appendChild(videoElement);
// }).catch((error) => {
//   console.error("Error playing back recording:", error);
// });


// Add event listeners to the UI elements
const chan = new BroadcastChannel('meeting-notifications');
document.getElementById("btnStartRecording").addEventListener("click", () => {
  // Start recording the meeting
  meeting.startRecording();
  
 
    console.log("Recording started");
    chan.postMessage({
      type: 'recording_started',
      message: Recording started by ${joinMeetingName}
    });

});

document.getElementById("btnStopRecording").addEventListener("click", () => {
  // Stop recording the meeting
  meeting.stopRecording();
  chan.postMessage({
    type: 'recording_stopped',
    message: `Recording stopped by ${joinMeetingName}`
  });
}); 

chan.onmessage = (event) => {
  if (event.data.type === 'recording_started') {
    // Example call
      notifyUserJoined(event.data.message); 

    // document.getElementById("notf").value = 
    // Update the UI to show a recording indicator
    // document.getElementById('recording-indicator').style.display = 'block';
  } else if (event.data.type === 'recording_stopped') {
    notifyUserJoined(event.data.message); 
    // Update the UI to hide the recording indicator
    // document.getElementById('recording-indicator').style.display = 'none';
  }
};
let notifyUserJoined = (data) => {
  const notification = document.createElement('div');
  notification.classList.add('notification');
  notification.innerText = data;
  console.log("done");
  document.body.appendChild(notification);
  setTimeout(() => {
      notification.remove();
  }, 5000);
};
// document.getElementById("playback-btn").addEventListener("click", () => {
//   // Playback a recorded meeting
//   meeting.playback(recordingId);
// });