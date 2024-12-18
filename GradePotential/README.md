# Grade Potential

[Grade Potential](https://www.gradepotentialtutors.com/) is a project designed using the [Unbounce](https://unbounce.com/) platform. This website offers personalized tutoring services, prioritizing an intuitive and professional experience for its users.

## Project Description

The Grade Potential website was developed with Unbounce, leveraging its flexibility to create high-conversion landing pages. Additionally, a set of custom scripts has been integrated to add advanced functionalities and enhance user interaction.

## Key Features

- **Responsive design**: Ensures an optimized experience across all devices.
- **Custom integrations**: Uses tailored scripts for advanced features.
- **Conversion-focused**: Unbounce tools designed to maximize engagement.

## Custom Scripts

The website incorporates several custom scripts to enrich the user experience. Below is a general overview of the implemented scripts:

1. **Dynamic Replacement**:
   This script [Dynamic Replacement](https://github.com/madebygarzon/pip-dev/blob/main/GradePotential/DynamicReplacement.js) customizes web page content dynamically based on URL parameters and data fetched from an external API. It is designed to personalize the user experience by tailoring content to geographic regions or user-specific data. Below is a high-level overview of its functionality:
   [Ubication](https://app.unbounce.com/5576070/variants/323375305/edit)  
   

    ### Key Features

    1.1. **URL Parameter Parsing**:
    - Captures parameters such as `geoHub`, `geoNum`, `loc`, `utm_source`, and `network` from the URL to configure the page dynamically.

    1.2. **Data Objects (`geoHubObj` and `geoNumObj`)**:
    - Contains mappings for geographic regions (`geoHubObj`) and phone numbers (`geoNumObj`) to their corresponding descriptions or formats.
    - Example: `"Greater WDC": "Serving the Washington Metro Area & All Surrounding Cities"`.

    1.3. **Dynamic Content Updates**:
    - Updates specific HTML elements based on the retrieved data:
        - **Phone Numbers**: Elements with the classes `number-replace` or `multi-number-replace`.
        - **Geographic Phrases**: Elements with the class `geophrase`.
        - **Cities**: Elements with the class `city-replace`.

    1.4. **API Integration**:
    - If the `loc` parameter is present, the script makes a call to a location API to fetch default phone numbers, city names, and location types.
    - The data retrieved is used to update the page content accordingly.
    - Includes a helper function to format phone numbers into a standardized format (`(XXX) XXX-XXXX`).

    1.5. **Fallback Handling**:
    - Provides default values for phone numbers (`"(888) 520-0511"`) and messages when specific parameters or data are unavailable.

    1.6. **Visibility Management**:
    - Ensures that elements with the class `visibility-toggle` are made visible after content updates.

    1.7. **Timeout Management**:
    - Implements a 5-second timeout for the API response to prevent blocking the execution flow in case of delays.

2. **Modal Looking For Local Tutor**:
    This script [Modal Looking For Local Tutor](https://github.com/madebygarzon/pip-dev/blob/main/GradePotential/ModalLookingForLocalTutor.js) dynamically creates and displays a modal window on a webpage to promote a tutoring service. The modal is designed to appear after a 5-second delay and includes responsive and interactive features to enhance user engagement. Below is an overview of its functionality:
    [Ubication](https://app.unbounce.com/5576070/variants/323375305/edit)  

    ### Key Features

    2.1. **Dynamic Creation**:
    - The modal is dynamically built using JavaScript.
    - Styles and HTML content are injected directly into the document at runtime.

    2.2. **Modal Design and Content**:
    - **Image Section**: Displays an image representing tutoring or education.
    - **Text Section**: Includes a title ("We'll send a great tutor to your house!") and a description encouraging the user to call.
    - **Call-to-Action Button**: Features a button with a dynamically updated phone number or a placeholder ("Loading...") if the data is not available.

    2.3. **Responsive Styling**:
    - Utilizes media queries to adjust dimensions, font sizes, and layout for different screen sizes.
    - Ensures optimal display on both mobile and desktop devices.

    2.4. **User Interaction**:
    - A **close button** (`&times;`) allows users to dismiss the modal.
    - A visually distinct `call-button` encourages user engagement and includes hover effects for interactivity.

    2.5. **Delayed Display**:
    - The modal is initially hidden and becomes visible 5 seconds after the page loads, triggered by toggling the `.show` class on the modal's backdrop.

    2.6. **Reusability**:
    - The script is self-contained and immediately executed, requiring no external dependencies or configuration, making it easily reusable.

    2.7. **Accessibility**:
    - Includes smooth transition effects (opacity and visibility) for better user experience when the modal appears or disappears.

    


## Project Structure

This project follows Unbounce's standard development structure, with scripts and configurations managed directly within the platform. Key areas of customization are as follows:

- **Landing pages**: Each page has a unique design tailored to different marketing objectives.
- **Script configurations**: Custom scripts are set up in the global or page-specific script sections within Unbounce.
- **Additional resources**: Multimedia files (images and videos) uploaded directly to Unbounce.

## How to Contribute

This project's development is centralized in the Unbounce platform. To suggest improvements or new features:

1. Contact the project's development team.
2. Provide clear details about the proposed functionality or enhancement.
3. If submitting a custom script, include well-documented code to facilitate integration.

