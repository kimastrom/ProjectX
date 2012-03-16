# File who contains all the other files in the project, plus
# some extra settings for libs like libqxt and qjson

QT       += core gui network # Selects which parts of Qt we want to use

TARGET = Snippt # The name of the app
TEMPLATE = app # Which kind of thing this is (in this case an app)

CONFIG  += qxt # libqxt lib for global shortcuts
QXT     += core gui # Selects which parts of libqxt we want to use

# Includes all cpp-files (files with real code)
SOURCES += main.cpp\
        mainwindow.cpp \
    jsonfuncs.cpp \
    filefuncs.cpp \
    apifuncs.cpp \
    cachefuncs.cpp \
    settingsfuncs.cpp \
    settingsdialog.cpp \
    customtreewidget.cpp \
    customcombobox.cpp

# Includes all h-files (files with header code)
HEADERS  += mainwindow.h \
    jsonfuncs.h \
    filefuncs.h \
    apifuncs.h \
    cachefuncs.h \
    settingsfuncs.h \
    settingsdialog.h \
    customtreewidget.h \
    customcombobox.h

# Includes all ui-files (files with gui-elements)
FORMS    += \
    mainwindow.ui \
    settingsdialog.ui

# Includes the qjson-lib for Mac OS X
macx: LIBS += -L$$PWD/libs/executables/macosx -lqjson
macx: INCLUDEPATH += $$PWD/libs/executables/macosx
macx: DEPENDPATH += $$PWD/libs/executables/macosx

# Includes the qjson-lib for Windows
win32: LIBS += -L$$PWD/libs/executables/windows -lqjson0

# Includes the libqxt-libs for Windows
win32: LIBS += -L$$PWD/libs/executables/windows -lQxtCore
win32: LIBS += -L$$PWD/libs/executables/windows -lQxtGui

# Includes resource for the Windows icon
OTHER_FILES += \
    Win32Icon.rc

# Include resource for the Windows icon
win32:RC_FILE += Win32Icon.rc

# Link against the lib-directory for windows-files
win32: INCLUDEPATH += $$PWD/libs/executables/windows
win32: DEPENDPATH += $$PWD/libs/executables/windows

# Includes the qjson-lib for Linux
unix!mac: LIBS += -L$$PWD/libs/executables/linux -lqjson

# Includes the libqxt-libs for Linux
unix!mac: LIBS += -L$$PWD/libs/executables/linux -lQxtCore
unix!mac: LIBS += -L$$PWD/libs/executables/linux -lQxtGui

# Link against the lib-directory for linux-files
unix!mac: INCLUDEPATH += $$PWD/libs/executables/linux
unix!mac: DEPENDPATH += $$PWD/libs/executables/linux
