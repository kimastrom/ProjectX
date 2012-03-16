// Class for working with the main user interface (where you can search snippets etc)

// Includes all the importen libs (in qt)
// that we need to use for this class to work
#include "mainwindow.h"
#include "ui_mainwindow.h"
#include <QMessageBox>
#include "jsonfuncs.h"
#include <QVariantList>
#include <QMessageBox>
#include <QList>
#include <QDir>
#include <QClipboard>
#include "apifuncs.h"
#include "cachefuncs.h"
#include <libs/code/libqxt/qxtapplication.h>
#include <libs/code/libqxt/qxtglobalshortcut.h>
#include <QTimer>
#include <QSettings>
#include <QDirIterator>
#include "customcombobox.h"
#include <QDesktopWidget>

// Move the window to the center of the screen
void MainWindow::CenterWindow()
{
    QRect windowGeometry = frameGeometry();
    windowGeometry.moveCenter(QDesktopWidget().availableGeometry().center());
}

// Constructor
MainWindow::MainWindow(QWidget *parent) : QMainWindow(parent), ui(new Ui::MainWindow)
{
    ui->setupUi(this); // Pointer to the interface-file (mainwindow.ui)

    this->CenterWindow();

    this->apiFuncs = new ApiFuncs(); // Instance of the ApiFuncs-class
    this->jsonFuncs = new JsonFuncs(); // Instance of the JsonFuncs-class
    this->cacheFuncs = new CacheFuncs(); // Instance of the CacheFuncs-class
    this->settingsFuncs = new SettingsFuncs(); // Instance of the SettingsFuncs-class
    this->fileFuncs = new FileFuncs(); // Instance of the FileFuncs-class
    this->animationTimer = new QTimer(this); // Instance of the QTimer-class (For the Searching...-animation)
    this->animationTimer2 = new QTimer(this); // Instance of the QTimer-class (For the Loading...-animation)
    this->keyboardShortcutActiveKey = new QxtGlobalShortcut(this); // Instance of the QxtGlobalShortcut-class
    this->keyboardShortcutCopyKey = new QxtGlobalShortcut(this); // Instance of the QxtGlobalShortcut-class
    this->settingsDialog = new SettingsDialog(); // Instance of the SettingsDialog-class

    // Set the headers for the treeview, who holds the snippets and its categories
    QStringList snippetListHeaders;
    snippetListHeaders << "Languages" << "Title" << "Description" << "By user" << "Created" << "Updated" << "Thumbs Up" << "Thumbs Down";
    ui->listSnippets->setHeaderLabels(snippetListHeaders);

    // Test the connection to the api (thru another method in another class), and show a message, if its an error with it
    bool testConnection = this->ShowPossiblyErrorAboutConnection();

    ui->foundNumberOfSnippets->setHidden(true);

    // Setup some sort of eventlisteners with signal and slots

    // Listen for the key to activate the window (and later on, made a search)
    connect(this->keyboardShortcutActiveKey, SIGNAL(activated()), this, SLOT(ShowWindowAndFocusSearchField()));

    // Listen for the ctrl+alt+c key to copy a selected snippet to clipboard
    connect(this->keyboardShortcutCopyKey, SIGNAL(activated()), this, SLOT(CopySelectedSnippet()));

    // Listen for the enter-key, when placed in searchfield, so the user can do a search with the enter-key
    // instead of pushing the graphical button
    connect(ui->searchField, SIGNAL(returnPressed()), this, SLOT(SearchSnippet()));

    // Read the settings about keyboard-commands and so on, from the saved settings
    // so it can be used in the application
    this->KeyboardActions();

    // Enable sorting in the treeview for snippets (so the user can click with the mouse on the headers, and sort the tree)
    ui->listSnippets->setSortingEnabled(true);

    // Populate the list with previous searches, with exactly what it is - old searches
    this->ListSearchFiles();

    // Setup some sort of eventlisteners with signal and slots

    // When the user click on a snippet, show it in the field where the code have its home
    connect(ui->listSnippets, SIGNAL(itemClicked(QTreeWidgetItem*,int)), this, SLOT(ShowSelectedSnippet(QTreeWidgetItem*,int)));

    // When the user chooses an old search, show its stored snippets in the treeview
    connect(ui->previousSearchesList, SIGNAL(currentIndexChanged(int)), this, SLOT(FillListWithPrevSearches(int)));

    // When the preferences dialog saves its settings for storing it, update the settings in realtime
    // so the application can use directly
    connect(this->settingsDialog, SIGNAL(UpdateKeyboardSettings()), this, SLOT(KeyboardActions()));

    // When the cache is cleared from the preferences dialog, update the interface for this window
    connect(this->settingsDialog, SIGNAL(ClearCache()), this, SLOT(UpdateInterface()));

    // When the user clicks a header, sort the list of snippets by that selected column
    connect(ui->listSnippets->header(), SIGNAL(sectionClicked(int)), this, SLOT(SortSnippetsByColumn(int)));

    // Listen for events regarding the mainwindow (not globally)
    this->installEventFilter(this); // REMEMBER TO COMMENT THIS WHEN BUILDING FOR WINDOWS AND LINUX

    // Show just a few elements (like searchfield, searchbutton, previous searches and deletebutton) in the window
    this->ShowAndHideElementsWithNewSearch();
}

// Test the connection to the api (thru another method in another class), and show a message, if its an error with it
bool MainWindow::ShowPossiblyErrorAboutConnection()
{
    bool testConnection = true;
    QString apiUrl = this->settingsFuncs->GetApiUrl();

    apiFuncs->ConnectToApi("nofile", apiUrl, testConnection, "");

    if (testConnection == false)
    {
        QMessageBox::information(this, "Can't connect!", "Can't connect to the API!\nAdd the right URL under Preferences"
                                 " in the Help/Application menu!\n\nIf its not working directly - try to restart the app a few times!\n\n"
                                 "Remember: You can always use the cached searches and snippetscode if there is any!");
        return false;
    }
    return true;
}

// Show all elements in the window
void MainWindow::ShowAllElements()
{
    this->CenterWindow();

    ui->searchLabel->show();
    ui->searchSnippet->show();
    ui->previousSearchesLabel->show();
    ui->previousSearchesList->show();
    ui->deleteSelectedPrevSearch->show();

    ui->listSnippetsLabel->show();
    ui->listSnippets->show();
    ui->foundNumberOfSnippets->show();
    ui->selectedSnippetLabel->show();
    ui->selectedSnippet->show();
    ui->copySnippet->show();

    this->setMinimumHeight(470);
    this->setMinimumWidth(909);
    this->setMaximumHeight(16777215);
    this->setMaximumWidth(16777215);
    this->resize(909, 470);
    this->CenterWindow();
    this->setSizePolicy(QSizePolicy::Minimum, QSizePolicy::Minimum);
    // Show the title, closebutton, minimizebutton and maximizebutton only
    this->setWindowFlags(Qt::Window | Qt::WindowTitleHint | Qt::WindowCloseButtonHint | Qt::WindowMinimizeButtonHint | Qt::WindowMaximizeButtonHint | Qt::CustomizeWindowHint);
    this->show();
}

// Show just a few elements (like searchfield, searchbutton, previous searches and deletebutton) in the window
void MainWindow::ShowAndHideElementsWithNewSearch()
{
    this->CenterWindow();

    ui->previousSearchesList->setCurrentIndex(0);

    ui->searchLabel->show();
    ui->searchSnippet->show();
    ui->previousSearchesLabel->show();
    ui->previousSearchesList->show();
    ui->deleteSelectedPrevSearch->show();

    ui->listSnippets->clear();
    ui->selectedSnippet->clear();

    ui->listSnippetsLabel->hide();
    ui->listSnippets->hide();
    ui->foundNumberOfSnippets->hide();
    ui->selectedSnippetLabel->hide();
    ui->selectedSnippet->hide();
    ui->copySnippet->hide();

    this->setMinimumHeight(160);
    this->setMinimumWidth(909);
    this->setMaximumHeight(160);
    this->setMaximumWidth(909);
    this->resize(1, 1);
    this->setSizePolicy(QSizePolicy::Maximum, QSizePolicy::Maximum);
    // Show the title, closebutton and the minimizebutton only
    this->setWindowFlags(Qt::Window | Qt::WindowTitleHint | Qt::WindowCloseButtonHint | Qt::WindowMinimizeButtonHint | Qt::CustomizeWindowHint);
    this->show();
}

// Listen to events in the window. This one listen to when the window minimizes
// and hide all elements in window, except: searchfield, searchbutton, previous searches and deletebutton
bool MainWindow::eventFilter(QObject *a_object, QEvent *a_event)
{
    if(a_event->type() == QEvent::WindowStateChange && isMinimized())
    {
        this->ShowAndHideElementsWithNewSearch();
    }
    return true;
}

// Search for a snippet, update fields, listing the snippets, show alerts and so on
void MainWindow::SearchSnippet()
{
    ui->listSnippets->clear();
    ui->selectedSnippet->clear();

    // Test the connection to the api (thru another method in another class), and show a message, if its an error with it
    bool testConnection = this->ShowPossiblyErrorAboutConnection();

    // If there wasn't an error with the api, move on
    if (testConnection == true)
    {
        // If there wasn't a match for the searchstring in the old searches, move on
        if (ui->previousSearchesList->findText(ui->searchField->text().trimmed()) == -1)
        {
            // If the search had more than 0 characters, move on
            if (ui->searchField->text().count() != 0)
            {
                // Start the animationtimer, which shows the user an animation (so he/she knows there is a search going on)
                connect(this->animationTimer, SIGNAL(timeout()), this, SLOT(UpdateSearchAnimation()));
                ui->searchLabel->setText("Searching");
                animationTimer->start(500); // Update the timer every half second

                // A dummy variable that don't do so much in this case
                bool testConn = true;

                QString apiUrl = settingsFuncs->GetApiUrl().toUtf8(); // Get the api-adress
                QString theDateAndTime = this->fileFuncs->GetUnixTime(0).toUtf8(); // Get the current date and time in unixtime

                // Do a search against the API, and if its a new search -> save the file with json-data
                apiFuncs->ConnectToApi("search" + theDateAndTime + ".search", apiUrl + "/search/" + ui->searchField->text(), testConn, ui->searchField->text());

                // Parse the latest cached json-data thru the parser,
                QVariantList jsonData = this->jsonFuncs->GetJsonObject
                (
                    cacheFuncs->GetCacheFileData("search" + theDateAndTime + ".search")
                );

                // If there is some stored json-data in the search, move on
                if (jsonData.count() > 0)
                {
                    this->ShowAllElements();

                    // Fill the tree with all snippets who got catched by the searchstring
                    this->FillListWithSnippets
                    (
                        jsonFuncs->GetJsonObject
                        (
                            cacheFuncs->GetCacheFileData("search" + theDateAndTime + ".search")
                        )
                    );

                    ui->foundNumberOfSnippets->setHidden(false);
                    QString snippetNumber;
                    snippetNumber.setNum(jsonData.count());
                    ui->foundNumberOfSnippets->setText(snippetNumber.toUtf8() + " snippets found!");
                    ui->listSnippets->setFocus();

                    // Select the first item in the tree
                    QTreeWidgetItemIterator item (ui->listSnippets);
                    ui->listSnippets->setCurrentItem(*item);

                    // Expand all categories
                    ui->listSnippets->expandAll();

                    ui->previousSearchesList->clear();
                    this->ListSearchFiles();
                }
                // If there wasn't a match with the searchstring, show a message and clear some fields etc
                else if (jsonData.count() <= 0)
                {
                    this->animationTimer->stop();
                    ui->searchLabel->setText("Search for a snippet (use for example: word + word or just search for one single word):");
                    ui->foundNumberOfSnippets->setHidden(false);
                    ui->foundNumberOfSnippets->setText("0 snippets found!");
                    QMessageBox::warning(this, "No snippets found", "Couldn't find any snippets that matches with your search.\n\nTry again!");
                    ui->previousSearchesList->setCurrentIndex(0);
                    ui->searchField->clear();
                    this->ShowAndHideElementsWithNewSearch();
                }
                // If there was an error with the api (about the json-data, not the connection), show a message about it and clear some fields etc
                else if (!jsonData.startsWith("["))
                {
                    this->animationTimer->stop();
                    ui->searchLabel->setText("Search for a snippet (use for example: word + word or just search for one single word):");
                    ui->foundNumberOfSnippets->setHidden(true);
                    QMessageBox::warning(this, "Api errors!", "Seems to be some errors with the API!\n\nTry again later or switch to another API-URL in settings!\n\nAnd try again!");
                    ui->searchField->clear();
                    ui->searchField->setFocus();
                }
            }
        }
        // If the user haven't type something into the searchfield, show a message about it
        else if (ui->searchField->text().count() == 0)
        {
            QMessageBox::warning(this, "Empty field!", "You can't search for nothing. \n\n(hint: empty field)\n\nTry again!");
        }
        // If the searchstring has been used earlier in an old search, show a message about it and clear some fields etc
        else
        {
            QMessageBox::warning(this, "There is an old searchitem!", "There is already a searchitem with that searchstring in the old searches!\n\nUse that one, or try again!");
            ui->searchField->clear();
            ui->previousSearchesList->setFocus();
            ui->foundNumberOfSnippets->setText("");
        }
    }
}

// Fill the tree with snippets
void MainWindow::FillListWithSnippets(QVariantList a_jsonObject)
{
    foreach(QVariant record, a_jsonObject)
    {
        QVariantMap map = record.toMap();
        QString language = map.value("language").toString(); // Language category for the snippets
        QString title = map.value("title").toString(); // Title for the snippet
        QString id = map.value("id").toString(); // Id for the snippet
        QString description = map.value("description").toString(); // Description for the snippet
        QString username = map.value("username").toString(); // Username for the snippet
        QString date = map.value("date").toString(); // Date and time for the snippet (When was the snippet created)
        QString update = map.value("updated").toString(); // Date and time for the snippet (When was the snippet updated)
        QString thumbsup = map.value("thumbsup").toString(); // If the user likes the snippet
        QString thumbsdown = map.value("thumbsdown").toString(); // If the user don't likes the snippet

        // Point to the items in tree
        QList<QTreeWidgetItem*> items = ui->listSnippets->findItems(language, Qt::MatchExactly, 0);

        // Fix stuff about the sorting etc
        if (items.count() == 0)
        {
            this->group = new QTreeWidgetItem(ui->listSnippets);
            this->group->setText(0, language);
        }
        // Group snippets under its specific language category
        else
        {
            group = items.at(0);
        }

        // Put the right info in the right column
        QTreeWidgetItem *child = new QTreeWidgetItem(this->group);
        child->setText(1, title);
        child->setText(2, description);
        child->setText(3, username);
        child->setText(4, date);
        child->setText(5, update);
        child->setText(6, thumbsup);
        child->setText(7, thumbsdown);
        QVariant idData(id);
        child->setData(1, Qt::UserRole,idData); // Set the id of every snippet to its own title (hidden data)
    }

    // Set witdh of columns
    ui->listSnippets->setColumnWidth(0, 120);
    ui->listSnippets->setColumnWidth(1, 180);
    ui->listSnippets->setColumnWidth(2, 80);
    ui->listSnippets->setColumnWidth(3, 80);
    ui->listSnippets->setColumnWidth(4, 125);
    ui->listSnippets->setColumnWidth(5, 125);
    ui->listSnippets->setColumnWidth(6, 80);
    ui->listSnippets->setColumnWidth(7, 80);
}

// List files of cached searches
void MainWindow::ListSearchFiles()
{
    // Add an empty item to the top of previous searches
    ui->previousSearchesList->addItem("", "");

    // Get the directory with old searches
    QDirIterator listFilesFromCacheDirectory(this->fileFuncs->GetUserDir(), QDir::Files);

    // Fill the list with searches
    while (listFilesFromCacheDirectory.hasNext())
    {
        listFilesFromCacheDirectory.next();

        // Look for files with the .search-prefix
        if (listFilesFromCacheDirectory.fileInfo().completeSuffix() == "search")
        {
            ui->previousSearchesList->addItem(this->fileFuncs->GetSearchString(listFilesFromCacheDirectory.fileName()).trimmed(),
                                              listFilesFromCacheDirectory.fileName());
        }
    }
}

// Destructor, who destroy some inital eventlisteners and deletes some inital class-instances
MainWindow::~MainWindow()
{
    disconnect(this->keyboardShortcutActiveKey, SIGNAL(activated()), this, SLOT(ShowWindowAndFocusSearchField()));
    disconnect(this->keyboardShortcutCopyKey, SIGNAL(activated()), this, SLOT(CopySelectedSnippet()));
    disconnect(ui->searchField, SIGNAL(returnPressed()), this, SLOT(SearchSnippet()));
    disconnect(ui->listSnippets, SIGNAL(itemClicked(QTreeWidgetItem*,int)), this, SLOT(ShowSelectedSnippet(QTreeWidgetItem*,int)));
    disconnect(ui->previousSearchesList, SIGNAL(currentIndexChanged(int)), this, SLOT(FillListWithPrevSearches(int)));
    disconnect(ui->listSnippets->header(), SIGNAL(sectionClicked(int)), this, SLOT(SortSnippetsByColumn(int)));
    disconnect(this->settingsDialog, SIGNAL(ClearCache()), this, SLOT(UpdateInterface()));
    delete this->apiFuncs;
    delete this->jsonFuncs;
    delete this->cacheFuncs;
    delete this->settingsFuncs;
    delete this->fileFuncs;
    delete this->animationTimer;
    delete this->animationTimer2;
    delete this->keyboardShortcutActiveKey;
    delete this->keyboardShortcutCopyKey;
    delete this->settingsDialog;
    delete ui;
}

// Open the about box
void MainWindow::on_aboutSnippt_triggered()
{
    QMessageBox::about(this, "About Snippt", "Snippt is a platform for searching snippets of code thru "
                       "an API and some client-applications for the web etc.\n\n"
                       "This is the client for Windows and Mac OS X");
}

// Open preferences dialog
void MainWindow::on_actionPreferences_triggered()
{
    this->settingsDialog->show();
}

// Load the global keyboard shortcuts from settings
void MainWindow::KeyboardActions()
{
    QVariant activeGlobalShortcuts, activeShortcut;

    QSettings settings("ProjectX", "Snippt");
    settings.beginGroup("SnipptSettings");

    // See if the keyboard shortcuts is active for using
    activeGlobalShortcuts = settings.value("activeglobalshortcuts");
    QString activeGlobalShortcutsConv = activeGlobalShortcuts.toString();

    // Get the keyboard shortcut for bringing the window to an active state
    activeShortcut = settings.value("activeshortcut");
    QString activeShortcutConv = activeShortcut.toString();

    // See if the keyboard shortcuts is active for using
    if (activeGlobalShortcutsConv == "activated")
    {
        this->keyboardShortcutActiveKey->setEnabled(true);
        this->keyboardShortcutCopyKey->setEnabled(true);

        this->keyboardShortcutActiveKey->setShortcut(QKeySequence(activeShortcutConv)); // Shortcut for activating the window
        this->keyboardShortcutCopyKey->setShortcut(QKeySequence("ctrl+alt+c")); // Shortcut for copy a selected snippet with Ctrl+Alt+C
    }
    else
    {
        this->keyboardShortcutActiveKey->setDisabled(true);
        this->keyboardShortcutCopyKey->setDisabled(true);
    }

    settings.endGroup();
}

// Raise the window (if its minimized) and clear searchfields etc
void MainWindow::ShowWindowAndFocusSearchField()
{
    this->showNormal();
    this->raise();
    this->activateWindow();
    ui->searchField->setFocus();
    ui->searchField->setText("");
    this->ShowAndHideElementsWithNewSearch();
}

// Update the search animation with dots and stop the timer if the api
// find something to put inside the tree with snippets
void MainWindow::UpdateSearchAnimation()
{
    QString oldText = ui->searchLabel->text();
    ui->searchLabel->setText(oldText + ".");

    bool snippets = ui->listSnippets->topLevelItemCount();

    if (snippets > 0)
    {
        this->animationTimer->stop();
        ui->searchLabel->setText("Search for a snippet (use for example: word + word or just search for one single word):");
    }
}

// Update loading animation for a snippet, so the user knows that a snippet is loading from
// the api or the cache
void MainWindow::UpdateLoadSnippetAnimation()
{
    QString oldText = ui->selectedSnippetLabel->text();
    ui->selectedSnippetLabel->setText(oldText + ".");

    if (ui->selectedSnippet->toPlainText() != "")
    {
        this->animationTimer2->stop();
        ui->selectedSnippetLabel->setText("Selected snippet:");
    }
}

// Show the selected snippet
void MainWindow::ShowSelectedSnippet(QTreeWidgetItem *a_item, int a_column)
{
    if (a_item->text(1) != "" || a_item->text(2) != "" || a_item->text(3) != "" || a_item->text(4) != ""
             || a_item->text(5) != "" || a_item->text(6) != "" || a_item->text(7) != "" || a_item->text(8) != "")
    {
        connect(this->animationTimer2, SIGNAL(timeout()), this, SLOT(UpdateLoadSnippetAnimation()));
        ui->selectedSnippetLabel->setText("Loading");
        animationTimer2->start(500); // Update the timer every half second
    }

    // Get the hidden id about the snippet (from the title)
    // so the loaded snippet code can have its own uniq name
    QString cacheSelectedSnippetFilename = a_item->data(1, Qt::UserRole).toString();

    QVariant apiUrl;
    bool testConn = true;
    QSettings settings("ProjectX", "Snippt");

    settings.beginGroup("SnipptSettings");

    apiUrl = settings.value("apiurl"); // Get the api-address
    QString apiUrlConv = apiUrl.toString();

    // Connect to the api and its cache-files, and get the selected snippetcode
    this->apiFuncs->ConnectToApi(cacheSelectedSnippetFilename, apiUrlConv.toUtf8() + "/search/" + cacheSelectedSnippetFilename, testConn, "");

    settings.endGroup();

    QByteArray jsonCacheData = this->cacheFuncs->GetCacheFileData(cacheSelectedSnippetFilename); // Load cached json-data
    QVariantList jsonObject = this->jsonFuncs->GetJsonObject(jsonCacheData); // Parse to json
    QString snippetCode = this->jsonFuncs->GetSnippetCode(jsonObject); // Get the code behind the snippet

    // If there is some code behind the snippet, enable the field for showing the snippet,
    // or hide if there wasn't any code
    if (cacheSelectedSnippetFilename != 0)
    {
        ui->copySnippet->setEnabled(true);
    }
    else
    {
        ui->copySnippet->setEnabled(false);
    }

    ui->selectedSnippet->setText(snippetCode);
}

// Clear all fields for the searchstring, selected snippet, listed snippets and so on
void MainWindow::ClearFields()
{
    ui->searchField->clear();
    ui->selectedSnippet->clear();
    ui->copySnippet->setEnabled(false);
}

// Fill the list with previous searches with cached searches
void MainWindow::FillListWithPrevSearches(int a_index)
{
    this->ClearFields();
    this->ShowAllElements();

    QString itemSearchString = ui->previousSearchesList->itemText(a_index).toUtf8(); // Searchstring
    QString itemSearchFile = ui->previousSearchesList->itemData(a_index).toString(); // File with json-data in it

    // Parse the latest cached json-data thru the parser,
    QVariantList jsonData = this->jsonFuncs->GetJsonObject
    (
        this->cacheFuncs->GetCacheFileData(itemSearchFile)
    );

    // If there is some stored json-data in the search, move on
    if (jsonData.count() > 0)
    {
        ui->listSnippets->clear();
        this->FillListWithSnippets
        (
            this->jsonFuncs->GetJsonObject
            (
                this->cacheFuncs->GetCacheFileData(itemSearchFile)
            )
        );
        ui->listSnippets->setFocus();
        QTreeWidgetItemIterator item (ui->listSnippets);

        // Select the first item in the treeview with snippets
        ui->listSnippets->setCurrentItem(*item);

        // Expand all categories with snippets, in the tree
        ui->listSnippets->expandAll();

        QString snippetNumber;
        snippetNumber.setNum(jsonData.count());
        ui->foundNumberOfSnippets->setText(snippetNumber.toUtf8() + " snippets found!");
    }

    // If there is some code behind the snippet, enable the field for showing the snippet,
    // or hide if there wasn't any code
    if (!itemSearchString.isEmpty())
    {
        ui->deleteSelectedPrevSearch->setEnabled(true);
    }
    else
    {
        ui->deleteSelectedPrevSearch->setEnabled(false);
    }
}

// Copy the selected snippet to clipboard
void MainWindow::CopySelectedSnippet()
{
    QClipboard *clipboard = QApplication::clipboard();
    clipboard->setText(ui->selectedSnippet->toPlainText());
}

// Sort the list of snippets by column, when the user
// presses one of the headers in the treeview
void MainWindow::SortSnippetsByColumn(int a_column)
{
    // Sort snippets by ascending order
    if (ui->listSnippets->header()->sortIndicatorOrder() == Qt::AscendingOrder)
    {
        for(int i = 0; i < 8; i++)
        {
            ui->listSnippets->sortItems(i, Qt::AscendingOrder);
        }
        ui->listSnippets->sortItems(a_column, Qt::AscendingOrder);
    }
    // Sort snippets by descending order
    else
    {
        for(int i = 0; i < 6; i++)
        {
            ui->listSnippets->sortItems(i, Qt::DescendingOrder);
        }
        ui->listSnippets->sortItems(a_column, Qt::DescendingOrder);
    }
}

// Button for copy the selected snippet to clipboard
void MainWindow::on_copySnippet_clicked()
{
    this->CopySelectedSnippet();
}

// Button for searching a snippet from a given searchstring
void MainWindow::on_searchSnippet_clicked()
{
    this->SearchSnippet();
}

// Delete a selected previous search
void MainWindow::on_deleteSelectedPrevSearch_clicked()
{
    int selectedItemIndex = ui->previousSearchesList->currentIndex(); // Get current selected search in previous searches
    QString itemSearchFile = ui->previousSearchesList->itemData(selectedItemIndex).toString(); // File with json-data in it

    // Delete the file and celar some fields
    if (this->fileFuncs->DeleteFile(itemSearchFile) == true)
    {
        ui->previousSearchesList->removeItem(selectedItemIndex);
        ui->previousSearchesList->setCurrentIndex(0);
        ui->deleteSelectedPrevSearch->setEnabled(false);
        ui->listSnippets->clear();
        ui->selectedSnippet->clear();
        ui->foundNumberOfSnippets->setText("");
        ui->foundNumberOfSnippets->setHidden(true);

        // Show just a few elements (like searchfield, searchbutton, previous searches and deletebutton) in the window
        if (ui->previousSearchesList->count() == 1)
        {
            this->ShowAndHideElementsWithNewSearch();
        }
    }
}

// When the cache is cleared update the interface (gui) by
// clearing all input-fields and so on
void MainWindow::UpdateInterface()
{
    ui->previousSearchesList->clear();
    ui->listSnippets->clear();
    this->ListSearchFiles();
    this->ClearFields();
    this->ShowAndHideElementsWithNewSearch();
}
