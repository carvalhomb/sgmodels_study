import httplib2
import pprint
import re

from apiclient.discovery import build
from apiclient.http import MediaFileUpload
from oauth2client.client import OAuth2WebServerFlow
from oauth2client.client import flow_from_clientsecrets
from oauth2client.file import Storage
from apiclient import errors

def startup():
  #returns the drive service
  
  # Copy your credentials from the console
  path_to_json="client_secret.json"    # download from https://code.google.com/apis/console/

  # Check https://developers.google.com/drive/scopes for all available scopes
  OAUTH_SCOPE = 'https://www.googleapis.com/auth/drive'

  # Redirect URI for installed apps
  REDIRECT_URI = 'urn:ietf:wg:oauth:2.0:oob'

  # Path to the file to upload
  #FILENAME = 'document.txt'

  # Are there any credentials stored?
  storage = Storage('gdrivecredentials')
  credentials = storage.get()

  # Run through the OAuth flow and retrieve credentials

  if (not credentials): #if we don't have credentials already stored, perform the authorization steps
  #flow = OAuth2WebServerFlow(CLIENT_ID, CLIENT_SECRET, OAUTH_SCOPE, redirect_uri=REDIRECT_URI) #online auth
    flow = flow_from_clientsecrets(path_to_json,OAUTH_SCOPE,redirect_uri="urn:ietf:wg:oauth:2.0:oob") #offline authorization for installed apps
    authorize_url = flow.step1_get_authorize_url()
    print('Go to the following link in your browser: ' + authorize_url)
    code = input('Enter verification code: ').strip()
    credentials = flow.step2_exchange(code)
    storage.put(credentials)

      
  # Create an httplib2.Http object and authorize it with our credentials
  http = httplib2.Http()
  http = credentials.authorize(http)

  return build('drive', 'v2', http=http)
  
def get_files_in_folder(service, folder_id):
  filelist = None
  page_token = None
  while True:
    try:
      param = {}
      if page_token:
        param['pageToken'] = page_token
      children = service.children().list(folderId=folder_id, maxResults=200, **param).execute()
      filelist = []
      for child in children.get('items', []):
        #print('File Id: %s' % child['id'])
        filelist.append(child['id'])
      page_token = children.get('nextPageToken')
      if not page_token:
        break
    except errors.HttpError as error:
      print('An error occurred: %s' % error)
      break
  return filelist

def format_file_list(service, filelist):
  #print('There are %s files in this list.' % len(filelist))
  filelist_formatted = ''
  for file_id in filelist:
    try:
      file = service.files().get(fileId=file_id).execute()
      filelist_formatted = filelist_formatted + "\n" + ('%s, %s, %s' % (file['title'], file_id, file['mimeType']))
    except errors.HttpError as error:
      print('An error occurred: %s' % error)
  return filelist_formatted

def publish_file(service, file_id, revision_id):
  #let's publish this file!
  patched_revision = {'published': True, 'publishAuto': True}
  try:
    return service.revisions().patch(fileId=file_id, revisionId=revision_id, body=patched_revision).execute()
  except errors.HttpError as error:
    print('An error occurred: %s' % error)
  return None
  
def build_filesets(service, filelist):
  #print('There are %s files in this list.' % len(filelist))
  filesets = dict()
  for file_id in filelist:
    fileset = {}
    participant_id = None
    try:
      file = service.files().get(fileId=file_id).execute()
      filename = file['title']
      participant_id = re.match("(\d{2})-", filename).group(1)
      if not participant_id in filesets:
        filesets[participant_id] = {}
      #print('participant id: %s' % participant_id)
      if 'ATMSGtables' in filename:
        filesets[participant_id]['ATMSGtables'] = file_id
      elif 'ATMSGdiagram' in filename:
        filesets[participant_id]['ATMSGdiagram'] = file_id
      elif 'LMGMtables' in filename:
        filesets[participant_id]['LMGMtables'] = file_id
      elif 'LMGMdiagram' in filename:
        filesets[participant_id]['LMGMdiagram'] = file_id
      #filelist_formatted = filelist_formatted + "\n" + ('%s, %s, %s' % (file['title'], file_id, file['mimeType']))
    except errors.HttpError as error:
      print('An error occurred: %s' % error)

  return filesets

  
####################################################
drive_service = startup()

folder_id = 'xxxx'
# get file list from the evaluations_live folder

filelist = get_files_in_folder(drive_service, folder_id)
#print(filelist)

filesets = build_filesets(drive_service, filelist)
#pprint.pprint(filesets)
output = ''

for pid,myset in filesets.items():
  substitutions = (myset['ATMSGdiagram'], myset['ATMSGtables'], myset['LMGMdiagram'], myset['LMGMtables'])
  sql = ''
  sql = "INSERT INTO `atmsg_db`.`docs` (`id`, `atmsg_diagram`, `atmsg_table`, `lmgm_diagram`, `lmgm_table`, `token`) VALUES (NULL, '%s', '%s', '%s', '%s', NULL);" % substitutions
  output = output + "\n" + sql
  
  
print(output)


'''
for fid in filelist:
  revision = drive_service.revisions().get(fileId=fid, revisionId='head').execute()
  lastrev = revision.get('id')
  #print('%s, %s' % (fid, lastrev))
  if (publish_file(drive_service, fid, lastrev)):
    print('Published file %s' % fid)
  else:
    print('WARNING! Check file %s' % fid)
'''

'''
testdoc_id = 'xxx'
testfile = drive_service.revisions().get(fileId=testdoc_id, revisionId='head').execute()
pprint.pprint(testfile)
print('revisionid? %s; published? %s; autopublished? %s; publishedlink? %s' % (testfile.get('id'), testfile.get('published'), testfile.get('publishAuto'), testfile.get('publishedLink')))
newrev = None
newrev = testfile.get('id')
print('-----------------------')
testfile_dopo = publish_file(drive_service, testdoc_id, newrev)
pprint.pprint(testfile_dopo)
print('published? %s; autopublished? %s; publishedlink? %s' % (testfile_dopo.get('published'), testfile_dopo.get('publishAuto'), testfile_dopo.get('publishedLink')))
'''



