[Setup]
AppName=Snippt
AppVersion=1.0
AppPublisher=Jens Evertsson
AppPublisherURL=""
AppSupportURL=""
AppUpdatesURL=""
DefaultDirName={pf}\Snippt
DisableDirPage=yes
DefaultGroupName=Snippt
DisableProgramGroupPage=yes
OutputDir=C:\Documents and Settings\Administrator\Desktop
OutputBaseFilename=Snippt
Compression=lzma
SolidCompression=yes

[Languages]
Name: "english"; MessagesFile: "compiler:Default.isl"

[Tasks]
Name: "desktopicon"; Description: "{cm:CreateDesktopIcon}"; GroupDescription: "{cm:AdditionalIcons}"; Flags: unchecked

[Files]
Source: "C:\Documents and Settings\Administrator\Desktop\Snippt_install\Filer\Snippt.exe"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\Documents and Settings\Administrator\Desktop\Snippt_install\Filer\qjson0.dll"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\Documents and Settings\Administrator\Desktop\Snippt_install\Filer\QtCore4.dll"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\Documents and Settings\Administrator\Desktop\Snippt_install\Filer\QtGui4.dll"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\Documents and Settings\Administrator\Desktop\Snippt_install\Filer\QtNetwork4.dll"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\Documents and Settings\Administrator\Desktop\Snippt_install\Filer\QxtCore.dll"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\Documents and Settings\Administrator\Desktop\Snippt_install\Filer\QxtGui.dll"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\Documents and Settings\Administrator\Desktop\Snippt_install\Filer\msvcp100.dll"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\Documents and Settings\Administrator\Desktop\Snippt_install\Filer\msvcp100d.dll"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\Documents and Settings\Administrator\Desktop\Snippt_install\Filer\msvcr100.dll"; DestDir: "{app}"; Flags: ignoreversion
Source: "C:\Documents and Settings\Administrator\Desktop\Snippt_install\Filer\msvcr100d.dll"; DestDir: "{app}"; Flags: ignoreversion

[Icons]
Name: "{group}\Snippt"; Filename: "{app}\Snippt.exe"
Name: "{group}\{cm:UninstallProgram,Snippt}"; Filename: "{uninstallexe}"
Name: "{commondesktop}\Snippt"; Filename: "{app}\Snippt.exe"; Tasks: desktopicon

[Run]
Filename: "{app}\Snippt.exe"; Description: "{cm:LaunchProgram,Snippt}"; Flags: nowait postinstall skipifsilent

[setup]
WizardImageFile = "snippt.bmp" 