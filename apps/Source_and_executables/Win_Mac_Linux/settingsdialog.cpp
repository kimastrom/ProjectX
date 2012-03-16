// Class for the preferences dialog

// Includes all the importen libs (in qt)
// that we need to use for this class to work
#include "settingsdialog.h"
#include "ui_settingsdialog.h"
#include <QSettings>
#include <QMessageBox>
#include <QRegExp>
#include <QRegExpValidator>
#include <QRect>
#include <QDesktopWidget>

// Constructor
SettingsDialog::SettingsDialog(QWidget *parent) : QDialog(parent), ui2(new Ui::SettingsDialog)
{
    ui2->setupUi(this); // Pointer to the interface-file (settingsdialog.ui)

    // Center the window to the center of the screen
    QRect windowGeometry = frameGeometry();
    windowGeometry.moveCenter(QDesktopWidget().availableGeometry().center());

    QVariant apiUrl, activeGlobalShortcuts, activeShortcut;
    QSettings settings("ProjectX", "Snippt");

    settings.beginGroup("SnipptSettings");

    // Get the the stored info about API URL
    apiUrl = settings.value("apiurl");
    QString apiUrlConv = apiUrl.toString();
    ui2->apiAddressField->setText(apiUrlConv.toUtf8());

    // Check if the global keyboard shortcuts are activated or not
    activeGlobalShortcuts = settings.value("activeglobalshortcuts");
    QString activeGlobalShortcutsConv = activeGlobalShortcuts.toString();

    // Check if the global keyboard shortcuts are activated or not
    if (activeGlobalShortcutsConv == "activated")
    {
        ui2->enableDisableGlobalShortcuts->setChecked(true);
        ui2->activeShortcutField->setEnabled(true);
    }
    else
    {
        ui2->enableDisableGlobalShortcuts->setChecked(false);
        ui2->activeShortcutField->setDisabled(true);
    }

    // Get the keyboard shortcut for activating the window
    activeShortcut = settings.value("activeshortcut");
    QString activeShortcutConv = activeShortcut.toString();
    ui2->activeShortcutField->setText(activeShortcutConv.toUtf8());

    settings.endGroup();

    // Activate regex validator (with regex code) for the api address field
    QRegExpValidator *regexValidator1 = new QRegExpValidator(this);
    QRegExp regexCode1("[a-z:/.]*");
    regexCode1.setCaseSensitivity(Qt::CaseInsensitive);
    regexValidator1->setRegExp(regexCode1);
    ui2->apiAddressField->setValidator(regexValidator1);

    // Activate regex validator (with regex code) for the field that holds the keyboard setting for bringing
    // the whole application to front/focus with some keys (if it's activated in the settings)
    QRegExpValidator *regexValidator2 = new QRegExpValidator(this);
    QRegExp regexCode2("[ctrl|alt|cmd|shift]{0,5}[+]{0,1}[a-z|ctrl|alt|cmd|shift]{0,5}[0-9]{0,1}[+]{0,1}[a-z]{0,1}[0-9]{0,1}");
    regexCode2.setCaseSensitivity(Qt::CaseInsensitive);
    regexValidator2->setRegExp(regexCode2);
    ui2->activeShortcutField->setValidator(regexValidator2);

    // Creating an instance of the FileFuncs-class, so we can clear the cache from files
    this->fileFuncs = new FileFuncs();
}

// Close the window, and shows a box if the API address is not filled in
void SettingsDialog::CloseWindow()
{
    if (ui2->apiAddressField->text() == "")
    {
        QMessageBox::warning(this, "No api adress!", "You haven't filled in an address to the API!\n\nTry again!");
        ui2->apiAddressField->setFocus();
    }
    else
    {
        this->close();
    }
}

// Listen to events in the window. This one listens to when the window closes
// and shows a box if the API address is not filled in
void SettingsDialog::closeEvent(QCloseEvent *a_event)
{
    this->CloseWindow();
}

// Destruktor
SettingsDialog::~SettingsDialog()
{
    delete this->fileFuncs; // Deletes the instance of the FileFuncs-class
    delete ui2; // Deletes the GUI from memory
}

// Save the given settings and close the window
void SettingsDialog::on_saveButton_clicked()
{
    QRegExp regexCode1("[a-z:/.]*"); // Accept only URL characters in the api address
    QRegExp regexCode2("[ctrl|alt|cmd|shift]{0,5}[+]{0,1}[a-z|ctrl|alt|cmd|shift]{0,5}[0-9]{0,1}[+]{0,1}[a-z]{0,1}[0-9]{0,1}"); // Accept only keyboard shortcut stuff
    bool isAddressValid = regexCode1.exactMatch(ui2->apiAddressField->text());
    bool isActiveKeyValid = regexCode1.exactMatch(ui2->apiAddressField->text());

    if (isAddressValid == true && isActiveKeyValid == true && ui2->apiAddressField->text() != "")
    {
        QSettings settings("ProjectX", "Snippt");
        settings.beginGroup("SnipptSettings");
        settings.setValue("apiurl", ui2->apiAddressField->text());

        if (ui2->enableDisableGlobalShortcuts->isChecked() == true)
        {
            settings.setValue("activeglobalshortcuts", "activated");
        }
        else
        {
            settings.setValue("activeglobalshortcuts", "deactivated");
        }

        settings.setValue("activeshortcut", ui2->activeShortcutField->text());
        settings.endGroup();
        settings.sync();

        QMessageBox::information(this, "Preferences", "Preferences has been saved!");
        emit UpdateKeyboardSettings();
        this->CloseWindow();
    }
    else if (isAddressValid == false)
    {
        QMessageBox::warning(this, "Api address is not valid!", "Api address is not valid!\n\nOnly letters, periods, slashes and colon is supported.\n\nTry again!");
    }
    else if (isActiveKeyValid == false)
    {
        QMessageBox::warning(this, "Active key is not valid!", "Active key is not valid!\n\nOnly letters, plus and numbers is supported.\n\nTry again!");
    }
    else if (ui2->apiAddressField->text() == "")
    {
        QMessageBox::warning(this, "No api adress!", "You haven't filled in an address to the API!\n\nTry again!");
    }
}

// Close the window
void SettingsDialog::on_closeButton_clicked()
{
    this->CloseWindow();
}

// Enables/disables the keyboard shortcut field
void SettingsDialog::on_enableDisableGlobalShortcuts_clicked()
{
    if (ui2->activeShortcutField->isEnabled())
    {
        ui2->activeShortcutField->setDisabled(true);
    }
    else
    {
        ui2->activeShortcutField->setEnabled(true);
    }
}

// Clear the cache from all files in there
void SettingsDialog::on_clearCacheButton_clicked()
{
    if (this->fileFuncs->DeleteAllCacheFilesAndDirectory() == true)
    {
        QMessageBox::information(this, "Cache files/folder deleted!", "All files and folders have been deleted!");
        emit this->ClearCache();
        this->close();
    }
    else
    {
        QMessageBox::warning(this, "Cache files/folder not deleted!", "The cache (files and folder) have not been deleted!\n\n"
                             "You can delete the folder and its files manually by removing the directory snippt_cache_files in your userfolder!");
    }
}
