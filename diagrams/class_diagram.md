<!-- # Diagramme de classes du système -->

classDiagram
    class User {
        +id: bigint
        +first_name: string
        +last_name: string
        +email: string
        +email_verified_at: datetime
        +password: string
        +role: UserRole
        +remember_token: string
        +created_at: datetime
        +updated_at: datetime
        +organizedEvents()
    }

    class UserRole {
        <<enumeration>>
        ADMIN
        ORGANIZER
        STAFF
        SCANNER
        GUEST
        +label()
        +all()
    }

    class Event {
        +id: bigint
        +name: string
        +description: text
        +location: string
        +start_date: datetime
        +end_date: datetime
        +organizer_id: bigint
        +created_at: datetime
        +updated_at: datetime
        +guests()
        +attendances()
    }

    class Guest {
        +id: bigint
        +first_name: string
        +last_name: string
        +email: string
        +phone: string
        +company: string
        +qr_code: uuid
        +event_id: bigint
        +invitation_sent: boolean
        +invitation_sent_at: datetime
        +created_at: datetime
        +updated_at: datetime
        +event()
        +attendance()
    }

    class Attendance {
        +id: bigint
        +guest_id: bigint
        +event_id: bigint
        +checked_in_at: datetime
        +checked_in_by: bigint
        +status: string
        +notes: text
        +created_at: datetime
        +updated_at: datetime
        +guest()
        +event()
        +checkedInBy()
    }

    User "1" --o "0..*" Event : organizes
    Event "1" --* "0..*" Guest : contains
    Event "1" --* "0..*" Attendance : has
    Guest "1" --o "0..1" Attendance : may have
    User "1" --o "0..*" Attendance : checks in
    User ..> UserRole : uses
