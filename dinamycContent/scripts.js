if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      (position) => {
        const { latitude, longitude } = position.coords;
  
        fetch(`https://api.bigdatacloud.net/data/reverse-geocode-client?latitude=${latitude}&longitude=${longitude}&localityLanguage=en`)
          .then((response) => response.json())
          .then((data) => {
            const city = data.city || "default";
            let contactNumber;
  
            switch (city.toLowerCase()) {
              case "miami":
                contactNumber = "+1-305-123-4567 \nYou are in Miami ☀️";
                break;
              case "new york":
                contactNumber = "+1-212-123-4567 \nYou are in New York 🗽";
                break;
              case "manizales":
                contactNumber = "+57 321 7979089 \nYou are in Manizales 🪭";
                break;
              case "pereira":
                contactNumber = "+57 320 7601766 \nYou are in Pereira 👨‍💻";
                break;
              default:
                contactNumber = "+1-800-123-4567 \nDefault information ☹️"; 
            }
  
            document.getElementById("contact-number").textContent = contactNumber;
          });
      },
      (error) => {
        console.error("Geolocation error:", error);
        document.getElementById("contact-number").textContent = "+1-800-123-4567"; 
      }
    );
  } else {
    console.error("Geolocation not supported by this browser.");
    document.getElementById("contact-number").textContent = "+1-800-123-4567"; 
  }
  

///////


const apiUrl = "https://ipinfo.io/json?token=ae9e462364fc9d"; 

async function getContactNumber() {
  try {
    const response = await fetch(apiUrl);
    if (!response.ok) {
      throw new Error("Error al obtener la ubicación.");
    }
    const data = await response.json();
    const city = data.city || "default"; 
    let contactNumber;

    switch (city.toLowerCase()) {
      case "miami":
        contactNumber = "+1-305-123-4567 \nYou are in Miami ☀️";
        break;
      case "new york":
        contactNumber = "+1-212-123-4567 \nYou are in New York 🗽";
        break;
      case "manizales":
        contactNumber = "+57 321 7979089 \nYou are in Manizales 🪭";
        break;
      default:
        contactNumber = "+1-800-123-4567 \nDefault information 🤔"; 
    }

    document.getElementById("contact-number-ip").textContent = contactNumber;
  } catch (error) {
    console.error("Error al determinar la ubicación:", error);
    document.getElementById("contact-number-ip").textContent = "+1-800-123-4567"; 
  }
}

getContactNumber();



