# PDF Planning

## Overview
A PHP library designed for the dynamic creation of weekly and location-based schedules in PDF format. 

## Key Features
- **Weekly Schedules**: Automatically generate weekly schedules with customizable time slots.
- **Location-Based Customization**: Tailor schedules for different locations with specific details.
- **High Customizability**: Modify text styles, border styles, and more to match specific branding or presentation requirements.
- **Reliability**: Includes a suite of unit tests to ensure stability and reliability across updates.

## Getting Started

### Prerequisites
- PHP 8.0 or higher
- Composer for managing PHP dependencies

### Installation

   ```sh
   composer require helip/pdf-planning
   ```

### Usage Example
Here’s how to quickly generate a schedule:

```php
use Helip\PdfPlanning\Builders\ScheduleWeeklyBuilder;

// Create a new schedule builder instance
$pdfPlanning = new ScheduleWeeklyBuilder();

// Create a new schedule entry
$entry = $pdfPlanning->createEntry()
                     ->setDay('Monday')
                     ->setTime('08:00 - 10:00')
                     ->setLocation('Room 101')
                     ->setActivity('Meeting with Team')
                     ->setInstructor('John Doe');

// Configure the schedule
$pdfPlanning->setTitle('My Weekly Schedule')
            ->addEntries(...$entries)  // Add entries dynamically
            .build();

// Save the generated PDF to a file
$pdfPlanning->save('path/to/save', 'my_schedule.pdf');
```

## Testing
Ensure the integrity of the schedules with our comprehensive test suite:

```sh
vendor/bin/phpunit
```

## Contributing
We welcome contributions from the community, whether they are feature enhancements, bug fixes, or documentation improvements. Please submit a pull request or raise an issue on GitHub.

## License
This project is licensed under the GNU Lesser General Public License v3.0 (LGPL-3.0), which allows both private and commercial use while ensuring that improvements to the library remain accessible to the community. For more details, see the `LICENSE` file.