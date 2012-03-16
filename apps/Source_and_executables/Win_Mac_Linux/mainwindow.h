// Class (header-file) for working with the main user interface (where you can search snippets etc)

// Beginning of header-file
#ifndef MAINWINDOW_H
#define MAINWINDOW_H

// Includes all the importen libs (in qt)
// that we need to use for this class to work
#include <QTreeWidgetItem>
#include <QVariantList>
#include <QMainWindow>
#include <QObject>
#include <QEvent>
#include <QKeyEvent>
#include "apifuncs.h"
#include "jsonfuncs.h"
#include "cachefuncs.h"
#include "settingsfuncs.h"
#include "filefuncs.h"
#include "settingsdialog.h"
#include <QTimer>
#include <libs/code/libqxt/qxtglobalshortcut.h>

// Namespace for the class
namespace Ui {
class MainWindow;
}

// Beginning of the class
class MainWindow : public QMainWindow // Subclass of the qwindow, so that we can add extra functionality to the window
{
    Q_OBJECT // A macro for making magic happen, when it comes to calling other classes from a class

// Member variables of the class
private:
    Ui::MainWindow *ui; // Pointer to the interface-file (mainwindow)
    ApiFuncs *apiFuncs; // Pointer to the ApiFuncs-class
    JsonFuncs *jsonFuncs; // Pointer to the JsonFuncs-class
    CacheFuncs *cacheFuncs; // Pointer to the CacheFuncs-class
    SettingsFuncs *settingsFuncs; // Pointer to the SettingsFuncs-class
    FileFuncs *fileFuncs; // Pointer to the FileFuncs-class
    QTimer *animationTimer; // Pointer to QTimer-class (For the Searching...-animation)
    QTimer *animationTimer2; // Pointer to QTimer-class (For the Loading...-animation)
    QxtGlobalShortcut *keyboardShortcutActiveKey; // Pointer to the QxtGlobalShortcut-class (for set the window as active)
    QxtGlobalShortcut *keyboardShortcutCopyKey; // Pointer to the QxtGlobalShortcut-class (for copy a selected snippet to clipboard)
    SettingsDialog *settingsDialog; // Pointer to the SettingsDialog-class
    QTreeWidgetItem *group; // Pointer for grouping snippets in the treeview

// Methods for the class
public:

    // Move the window to the center of the screen
    void CenterWindow();

    // Constructor
    explicit MainWindow(QWidget *parent = 0);

    // Test the connection to the api (thru another method in another class), and show a message, if its an error with it
    bool ShowPossiblyErrorAboutConnection();

    // Fill the tree with snippets
    void FillListWithSnippets(QVariantList a_jsonObject);

    // List files of cached searches
    void ListSearchFiles();

    // Destruktor
    ~MainWindow();

// Slots for the class (a slot is a method, that a signal can call (like events))
private slots:

    // Open the about box
    void on_aboutSnippt_triggered();

    // Load the global keyboard shortcuts from settings
    void KeyboardActions();

    // Raise the window (if its minimized) and clear searchfields etc
    void ShowWindowAndFocusSearchField();

    // Show all elements in the window
    void ShowAllElements();

    // Show just a few elements (like searchfield, searchbutton, previous searches and deletebutton) in the window
    void ShowAndHideElementsWithNewSearch();

    // Listen to events in the window. This one listen to when the window minimizes
    // and hide all elements in window, except: searchfield, searchbutton, previous searches and deletebutton
    bool eventFilter(QObject *a_object, QEvent *a_event);

    // Search for a snippet, update fields, listing the snippets, show alerts and so on
    void SearchSnippet();

    // Update the search animation with dots and stop the timer if the api
    // find something to put inside the tree with snippets
    void UpdateSearchAnimation();

    // Update loading animation for a snippet, so the user knows that a snippet is loading from
    // the api or the cache
    void UpdateLoadSnippetAnimation();

    // Show the selected snippet
    void ShowSelectedSnippet(QTreeWidgetItem *a_item, int a_column);

    // Clear all fields for the searchstring, selected snippet, listed snippets and so on
    void ClearFields();

    // Fill the list with previous searches with cached searches
    void FillListWithPrevSearches(int a_index);

    // Copy the selected snippet to clipboard
    void CopySelectedSnippet();

    // Sort the list of snippets by column, when the user
    // presses one of the headers in the treeview
    void SortSnippetsByColumn(int a_column);

    // Button for copy the selected snippet to clipboard
    void on_copySnippet_clicked();

    // Open preferences dialog
    void on_actionPreferences_triggered();

    // Button for searching a snippet from a given searchstring
    void on_searchSnippet_clicked();

    // Delete a selected previous search
    void on_deleteSelectedPrevSearch_clicked();

    // When the cache is cleared update the interface (gui) by
    // clearing all input-fields and so on
    void UpdateInterface();
};
// Ending of the class

#endif // MAINWINDOW_H
