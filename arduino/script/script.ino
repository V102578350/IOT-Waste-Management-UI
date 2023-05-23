#include <ArduinoJson.h>

namespace Pin {
constexpr static uint8_t laser = 9;
constexpr static uint8_t photoresistor = A0;
}

namespace Settings {
int photoresistor_threshold = 535;
uint64_t sample_period_ms = 1000;
float required_percent = 0.5f;
}

struct BinInfo {
  uint8_t id;
  String location;
  int volume;
};

BinInfo binInfo = {0, "Jake's Bin", 125};

bool isAboveThreshold() {
  return analogRead(Pin::photoresistor) > Settings::photoresistor_threshold;
}

void setup() {
  Serial.begin(9600);
  pinMode(Pin::laser, OUTPUT);
  digitalWrite(Pin::laser, HIGH);
}

void queryBinState() {
  // sample for 1 sample period
  uint64_t start_time = millis();
  auto duration = [&]() {
    return static_cast<uint64_t>(millis()) - start_time;
  };
  uint64_t samples = 0;
  uint64_t above_threshold_count = 0;
  while (duration() < Settings::sample_period_ms) {
    ++samples;
    above_threshold_count += isAboveThreshold();
  }

  // take average to check whether it's on or not (based off 50%);
  bool above_x_amount = (float)above_threshold_count / (float)samples > Settings::required_percent;

  // generate JSON data
  DynamicJsonDocument doc(256);
  doc["method"] = "queryBin";
  doc["binId"] = binInfo.id;
  doc["binLocation"] = binInfo.location;
  doc["binVolume"] = binInfo.volume;
  doc["binStatus"] = above_x_amount ? "NOT FULL" : "FULL";
  
  serializeJson(doc, Serial);
  Serial.println();
}

void updateVolume(String volumeStr) {
  int volume = volumeStr.toInt();
  binInfo.volume = volume;
}

void updateLocation(String locationStr) {
  binInfo.location = locationStr;
}

void loop() {
  if (Serial.available()) {
    String message = Serial.readString();
    message.trim();
    if (message.startsWith("queryBin")) {
      queryBinState();
    } else if (message.startsWith("updateVolume")) {
      // extract the volume value from the message
      int spaceIndex = message.indexOf(' ');
      String volumeStr = message.substring(spaceIndex + 1);
      volumeStr.trim();

      // perform action with the extracted volume value
      // For example, you can use it to update the volume:
      updateVolume(volumeStr);
    } else if (message.startsWith("updateLocation")) {
      // extract the location value from the message
      int spaceIndex = message.indexOf(' ');
      String locationStr = message.substring(spaceIndex + 1);
      locationStr.trim();

      // perform action with the extracted location value
      // For example, you can use it to update the location:
      updateLocation(locationStr);
    }
  }
}