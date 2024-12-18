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
   This script customizes web page content dynamically based on URL parameters and data fetched from an external API. It is designed to personalize the user experience by tailoring content to geographic regions or user-specific data. Below is a high-level overview of its functionality:

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

