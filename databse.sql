CREATE TABLE [dbo].[MenuPermission](
    [MenuID] [varchar](30) NOT NULL,
    [RoleID] [varchar](30) NOT NULL
    ) ON [PRIMARY]

CREATE TABLE [dbo].[Menus](
    [MenuID] [varchar](30) NOT NULL,
    [MenuName] [varchar](20) NOT NULL,
    [MenuIcon] [varchar](100) NOT NULL,
    [MenuLink] [varchar](255) NOT NULL,
    [MenuOrder] [int] NOT NULL
    ) ON [PRIMARY]

CREATE TABLE [dbo].[Notifications](
    [id] [varchar](255) NOT NULL,
    [type] [varchar](255) NOT NULL,
    [notifiable_type] [varchar](255) NOT NULL,
    [notifiable_id] [bigint] NULL,
    [data] [text] NOT NULL,
    [read_at] [datetime] NULL,
    [created_at] [datetime] NULL,
    [updated_at] [datetime] NULL,
    )


CREATE TABLE [dbo].[RegisteredVaccineUser](
    [Id] [int] IDENTITY(1,1) NOT NULL,
    [NID] [numeric](18, 0) NOT NULL,
    [FullName] [nvarchar](500) NOT NULL,
    [Age] [numeric](18, 0) NOT NULL,
    [Email] [varchar](255) NOT NULL,
    [Phone] [numeric](18, 0) NOT NULL,
    [VaccineCenterCode] [varchar](255) NOT NULL,
    [AppointmentDay] [date] NULL,
    [EntryDate] [datetime] NOT NULL,
    [IpAddress] [varchar](50) NOT NULL,
    CONSTRAINT [PK_TRegisteredVaccineUser] PRIMARY KEY CLUSTERED
)
CREATE TABLE [dbo].[VaccineCenter](
    [Id] [int] IDENTITY(1,1) NOT NULL,
    [VaccineCenterCode] [nvarchar](50) NOT NULL,
    [VaccineCenterName] [nvarchar](1000) NOT NULL,
    [PerDayCapacity] [numeric](18, 0) NOT NULL,
    [TotalAllocation] [numeric](18, 0) NULL,
    CONSTRAINT [PK_VaccineCenter] PRIMARY KEY CLUSTERED
)
CREATE TABLE [dbo].[Users](
    [Id] [int] IDENTITY(1,1) NOT NULL,
    [UserID] [varchar](10) NULL,
    [Name] [varchar](50) NOT NULL,
    [Email] [varchar](50) NULL,
    [Mobile] [varchar](20) NOT NULL,
    [NID] [varchar](50) NULL,
    [Address] [varchar](255) NULL,
    [RawPassword] [varchar](255) NOT NULL,
    [Password] [varchar](255) NOT NULL,
    [RoleID] [varchar](20) NOT NULL,
    [Status] [tinyint] NULL,
    [CreatedBy] [varchar](10) NOT NULL,
    [UpdatedBy] [varchar](10) NULL,
    [CreatedAt] [datetime] NOT NULL,
    [UpdatedAt] [datetime] NULL,
    [OtpCode] [varchar](10) NULL,
    [OtpVerification] [tinyint] NULL
)
